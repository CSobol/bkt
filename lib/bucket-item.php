<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bucket-item
 *
 * @author Chris
 */
class bucketItem {
    public $title, $description, $thumb, $numBucketLists, $generalCategory, $specificCategory, $nearby, $moreInfo;
    private $wikiQuery, $imageQuery;
    function __construct($title, $description, $thumb, $numBucketLists, $categories) {
        $this->title = $title;
        $this->description = $description;
        $this->thumb = $thumb;
        $this->numBucketLists = $numBucketLists;
        $this->categories = $categories;
        $this->wikiQuery = "http://en.wikipedia.org/w/api.php?format=json&action=query&titles=" . $this->specificCategory . "&prop=revisions|imageinfo|images&rvprop=content&iiprop=url&redirects=1";
        //Query wikipedia, find images
        
        $this->imageQuery = "http://en.wikipedia.org/w/api.php?format=json&action=query&titles=$imageTitle&prop=imageinfo&iiprop=url&redirects=1";
    }
    //END __construct
    private function getReadMore(){
        //pull from wikipedia
    }
    //END readMore
    private function getImageInfo(){
    
    }
    //endGetImageInfo
    private function returnImageFromInfo(){
        
    }
}
//END bucketItem class
?>
