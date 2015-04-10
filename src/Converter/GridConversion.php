<?php
namespace Converter;

class GridConversion extends ConversionRule
{
    private $_kvpair;
    private $_tag;
    private $_element;

    protected $_rules;


    public function __construct($tag, $kvpair)
    {
        $this->_tag = $tag;
        $this->_kvpair = $kvpair;

        // match opening tag and retrieve the element name
        preg_match('/^<(\w+)\s/', $this->_tag, $matches);
        if( $matches && count($matches) == 2 )
            $this->_element = $matches[1];

        $this->_rules = array(
            "row-fluid" => "row",
            "container-fluid" => "",
            "span(\\d+)" => array("col-md-$1", 'specialReplace'),
            "offset(\\d+)" => array("col-lg-offset-$1", 'specialReplace')
        );
    }

    /**
     * Revamped Grid System
     *
     * * Looks for 'spanX' non-form containers and replaces with 'col-md-X'
     * * Looks for 'offsetX' non-form containers and replaces with 'col-lg-offset-X'
     * * Change 'row-fluid' to 'row'
     * * Remove 'container-fluid'
     */
    public function run()
    {
        // take the class attribute for element $_tag
        if( array_key_exists('class', $this->_kvpair) )
        {
            $before = $this->_kvpair['class'];

            // each rule
            foreach( $this->_rules as $old => $new )
            {
                // plain old preg_replace, or custom replace?
                if( is_array($new) )
                    $this->_kvpair['class'] = call_user_func_array(array($this, $new[1]), array($old, $new, $this->_kvpair));
                else
                    $this->_kvpair['class'] = preg_replace("/$old/", $new, $this->_kvpair['class']);
            }

            // set modified
            if( $before != $this->_kvpair['class'] )
                $this->is_modified = true;
        }

        return $this->_kvpair;
    }

    /**
     * Only runs class replacement if conditions are met
     *
     * @param string $old regex
     * @param array $new (css class, callable)
     * @param string $pair key value pair
     * @return mixed replaced class name
     */
    private function specialReplace($old, $new, $pair)
    {
        // only preg_replace if we are <section> <div> <aside> or <article>
        if( strpos('section|div|aside|article', $this->_element) !== false )
        {
            return preg_replace("/$old/", $new[0], $pair['class']);
        } else
            $this->is_notable = true;

        // else return the original class
        return $pair['class'];
    }
}