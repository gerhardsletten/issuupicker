<?php
/**
 * File containing IssuuPicker datatype definition
 *
 */
class IssuuPickerType extends eZDataType
{
    const DATA_TYPE_STRING = 'issuupicker';

    const CONTENT_FIELD_VARIABLE = '_issuupicker_data_text_';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::eZDataType( self::DATA_TYPE_STRING, 'Issuu document picker' );
    }

    // --------------------------------------
    // Methods concerning the CLASS attribute
    // --------------------------------------

    /**
     * Sets default values for a new class attribute.
     * @param eZContentClassAttribute $classAttribute
     * @return void
     */
    public function initializeClassAttribute( $classAttribute )
    {
        // nothing to initialize
        return;
    }

    /**
     * Validates the input from the class definition form concerning this attribute.
     * @param eZHTTPTool $http
     * @param string $base Seems to be always 'ContentClassAttribute'.
     * @param eZContentClassAttribute $classAttribute
     * @return int eZInputValidator::STATE_ACCEPTED|eZInputValidator::STATE_INVALID|eZInputValidator::STATE_INTERMEDIATE
     */
    public function validateClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        return eZInputValidator::STATE_ACCEPTED;
    }

    /**
     * Handles the input specific for one attribute from the class edit interface.
     * @param eZHTTPTool $http
     * @param string $base Seems to be always 'ContentClassAttribute'.
     * @param eZContentClassAttribute $classAttribute
     * @return void
     */
    public function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        // Nothing to fetch
        return;
    }

    // --------------------------------------
    // Methods concerning the OBJECT attribute
    // --------------------------------------

    /**
     * Initializes object attribute before displaying edit template
     * Can be useful to define default values. Default values can be defined in class attributes
     * @param eZContentObjectAttribute $contentObjectAttribute Object attribute for the new version
     * @param int $currentVersion Version number. NULL if this is the first version
     * @param eZContentObjectAttribute $originalContentObjectAttribute Object attribute of the previous version
     * @see eZDataType::initializeObjectAttribute()
     */
    public function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        // Nothing to initialize
        return;
    }

    /**
     * Validates input on content object level
     * @param eZHTTPTool $http
     * @param string $base POST variable name prefix (Always "ContentObjectAttribute")
     * @param eZContentObjectAttribute $contentObjectAttribute
     * @return eZInputValidator::STATE_ACCEPTED|eZInputValidator::STATE_INVALID|eZInputValidator::STATE_INTERMEDIATE
     */
    public function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $fieldName = $base . self::CONTENT_FIELD_VARIABLE . $contentObjectAttribute->attribute( 'id' );
        $returnState = eZInputValidator::STATE_ACCEPTED;

        if( $http->hasPostVariable( $fieldName ) )
        {
            $fieldValue = $http->postVariable( $fieldName );
            if( trim( $fieldValue ) != '' )
            {
                //120523084643-6159c8fb60e9433faf83c1d1118b158e
                //120120123102-46ff3843bf76424a92ce23d568e1e65c
                $pattern = '/^[0-9]{12}\-[0-9a-f]{32}$/';
                //print_r(preg_match( $pattern, $fieldValue, $matches ));
                //die();
                if( preg_match( $pattern, $fieldValue, $matches ) == 0 )
                {
                    $validationError = 'Invalid Issuu document code';
                    $contentObjectAttribute->setValidationError( $validationError );
                    $returnState = eZInputValidator::STATE_INVALID;
                }
            }
        }

        return $returnState;
    }

    /**
     * Fixes up the data that has been posted with the object edit form
     * This method is called only if validation method (self::validateObjectAttributeHTTPInput()) returned eZInputValidator::STATE_INTERMEDIATE
     * @param eZHTTPTool $http
     * @param string $base
     * @param eZContentObjectAttribute $objectAttribute
     * @see eZDataType::fixupObjectAttributeHTTPInput()
     */
    public function fixupObjectAttributeHTTPInput( $http, $base, $objectAttribute )
    {

    }

    /**
     * Fetches all variables from the object and handles them
     * Data store can be done here
     * @param eZHTTPTool $http
     * @param string $base POST variable name prefix (Always "ContentObjectAttribute")
     * @param eZContentObjectAttribute $contentObjectAttribute
     * @return true if fetching of class attributes are successfull, false if not
     */
    public function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $fieldName = $base . self::CONTENT_FIELD_VARIABLE . $contentObjectAttribute->attribute( 'id' );

        if( $http->hasPostVariable( $fieldName ) )
        {
            $contentObjectAttribute->setAttribute( 'data_text', $http->postVariable( $fieldName ) );
        }

        return true;
    }

    /**
     * Performs necessary actions with attribute data after object is published
     * Returns true if the value was stored correctly
     * @param eZContentObjectAttribute $contentObjectAttribute
     * @param eZContentObject $contentObject The published object
     * @param array $publishedNodes
     * @return bool
     * @see eZDataType::onPublish()
     */
    public function onPublish( $contentObjectAttribute, $contentObject, $publishedNodes )
    {
        return;
    }

    /**
     * Checks if current content object attribute has content
     * Returns true if it has content
     * @param eZContentObjectAttribute $contentObjectAttribute
     * @return bool
     * @see eZDataType::hasObjectAttributeContent()
     */
    public function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return trim( $contentObjectAttribute->attribute( 'data_text' ) ) != '';
    }

    /**
     * Returns the content.
     * @param eZContentObjectAttribute
     * @return string
     */
    public function objectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    /**
     * Returns the meta data used for storing search indeces.
     * @param eZContentObjectAttribute
     * @return string
     */
    public function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    /**
     * Initializes the object attribute from a string representation
     * @param eZContentObjectAttribute
     * @param string
     * @see eZDataType::fromString()
     */
    public function fromString( $objectAttribute, $string )
    {
        $objectAttribute->setAttribute( 'data_text', $string );
    }

    /**
     * Returns the string representation of the object attribute
     * @param eZContentObjectAttribute
     * @see eZDataType::toString()
     * @return string
     */
    public function toString( $objectAttribute )
    {
        return $objectAttribute->attribute( 'data_text' );
    }

}

eZDataType::register( IssuuPickerType::DATA_TYPE_STRING, 'IssuuPickerType' );