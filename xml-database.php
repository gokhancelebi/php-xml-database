<?php

# xml based static database class for the application
# store the lines in xml file
# read and write arrays as xml
class XMLDatabase
{
    private $xml = null;

    public function __construct($xml_file)
    {
        $this->xml_file = $xml_file;
        $this->xml = simplexml_load_file($this->xml_file);
    }

    public function write($array){
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($array, array($this->xml, 'addChild'));
        $xml->asXML($this->xml_file);
    }

    public function read(){
        return json_decode(json_encode($this->xml), true);
    }

    # add line to xml file
    public function addLine($line){
        $this->xml->addChild('line', $line);
    }

    # save xml file
    public function save(){
        $this->xml->asXML($this->xml_file);
    }

    # search for a specific value in the xml file and return all the lines that contain it in array
    public function search($value){
        $result = array();
        foreach($this->xml->children() as $child){
            if(strpos($child, $value) !== false){
                array_push($result, $child);
            }
        }
        return $result;
    }

    # search for a spesific value in the xml file and return the line that contains it
    public function search_one($value){
        foreach( $this->xml->children() as $child){
            if(strpos($child, $value) !== false){
                return $child;
            }
        }
        return null;
    }

    # search for a spesfic value and key in the xml file and return all the lines that contain it in array
    public function search_key($value, $key){
        $result = array();
        foreach( $this->xml->children() as $child){
            if(strpos($child->$key, $value) !== false){
                array_push($result, $child);
            }
        }
        return $result;
    }

    # search for a spesfic value and key in the xml file and return all the line that contain it
    public function search_key_value($value, $key){
        $result = array();
        foreach( $this->xml->children() as $child){
            if(strpos($child->$key, $value) !== false){
                $result = $child;
            }
        }
        return $result;
    }


}