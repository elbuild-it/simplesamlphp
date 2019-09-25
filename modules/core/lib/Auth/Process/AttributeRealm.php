<?php

namespace SimpleSAML\Module\core\Auth\Process;

/**
 * Filter that will take the user ID on the format 'andreas@uninett.no'
 * and create a new attribute 'realm' that includes the value after the '@' sign.
 *
 * @author Andreas Åkre Solberg, UNINETT AS.
 * @package SimpleSAMLphp
 * @deprecated Use ScopeFromAttribute instead.
 */

class AttributeRealm extends \SimpleSAML\Auth\ProcessingFilter
{
    /** @var string */
    private $attributename = 'realm';


    /**
     * Initialize this filter.
     *
     * @param array &$config  Configuration information about this filter.
     * @param mixed $reserved  For future use.
     */
    public function __construct(array &$config, $reserved)
    {
        parent::__construct($config, $reserved);

        if (array_key_exists('attributename', $config)) {
            $this->attributename = $config['attributename'];
        }
    }


    /**
     * Apply filter to add or replace attributes.
     *
     * Add or replace existing attributes with the configured values.
     *
     * @param array &$request  The current request
     * @return void
     */
    public function process(array &$request) : void
    {
        assert(array_key_exists('Attributes', $request));

        if (!array_key_exists('UserID', $request)) {
            throw new \Exception('core:AttributeRealm: Missing UserID for this user. Please'.
                ' check the \'userid.attribute\' option in the metadata against the'.
                ' attributes provided by the authentication source.');
        }
        $userID = $request['UserID'];
        $decomposed = explode('@', $userID);
        if (count($decomposed) !== 2) {
            return;
        }
        $request['Attributes'][$this->attributename] = [$decomposed[1]];
    }
}
