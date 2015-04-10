<?php
namespace Converter;


/**
 * Created by PhpStorm.
 * User: simonwillan
 * Date: 08/04/15
 * Time: 11:19
 */
class BootstrapConverter
{
    private $_parentDir;

    protected $active;

    public $affected_files = array();
    public $notable_files = array();


    public function __construct($directory)
    {
        $this->_parentDir = $directory;
    }

    /**
     * Begin conversion process
     */
    public function begin()
    {
        // create a directory iterator
        $iter = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->_parentDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        /**
         * @var  string $path
         * @var  \SplFileInfo $dir
         */
        $count = 0;
        $files = array();
        foreach( $iter as $path => $dir )
        {
            if( $dir->getExtension() == 'html' )
            {
                $files[] = $path;
                $this->active = $path;
                $this->replace($path);
                $count++;
            }

            // break after first file has been read, debug only.
            //if( $count == 1 ) break;
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'files'          => $files,
            'count'          => $count,
            'affected'       => $this->affected_files,
            'affected_count' => count($this->affected_files)
        ));
        exit;
    }

    /**
     * Regex match the contents of each html file for its markup.
     *
     * @param string $path
     */
    private function replace($path)
    {
        $string = file_get_contents($path);

        // regex finds html tags, but not closing html tags, $result = the final modified file (as string)
        $result = preg_replace_callback('/<[^\/](?:"[^"]*"|\'[^\']*\'|[^\'">])*>/', array($this, 'matchAttributes'), $string);

        // TODO :: WRITE BACK TO FILE  IF PERMISSIONS PREVENT THIS, OUTPUT TO NEW FILE. (LET USER SPECIFY DIRECTORY?)
    }

    /**
     * Callback for HTML tag regex.
     * Performs regex on the html tag match to determine attribute key value pairs.
     *
     * @param $tag
     * @return string
     */
    private function matchAttributes($tag)
    {
        $tag = $tag[0];

        $replacement = preg_replace_callback('/(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/',
            function ($match) use ($tag) {
                return $this->convert($match, $tag);
            }, $tag);

        return $replacement;
    }

    /**
     * Executed on match of attributes within an HTML tag.
     * Performs all of the conversion commands
     *
     * @param $match
     * @param $tag
     * @return string
     */
    private function convert($match, $tag)
    {
        $kvpair = array($match[1] => $match[2]);
        $modified = 0;
        $notable = 0;

        // 1st conversion
        $gridRule = new GridConversion($tag, $kvpair);
        $result = $gridRule->run();
        if( $gridRule->is_modified ) $modified ++;
        if( $gridRule->is_notable ) $notable ++;


        // TODO :: USING GridConversion AS AN EXAMPLE, CREATE FURTHER CONVERSION SCRIPTS



        // generate replacement string
        foreach($result as $k => $v)
            $replacement = (!!$v) ? $k.'="'.$v.'"' : '';


        // add file to list of affected files
        if( $modified && !in_array($this->active, $this->affected_files) )
            $this->affected_files[] = $this->active;


        return $replacement;
    }
}