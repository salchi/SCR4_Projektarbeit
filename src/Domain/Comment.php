<?php

namespace Domain;

class Comment extends Entity{
    private $originator;
    private $text;
    private $creationDate;
    private $discussionId;
    
    public function __construct($id, $discussionId, $originator, $text, $creationDate) {
        parent::__construct($id);

        $this->originator = $originator;
        $this->text = $text;
        $this->discussionId = $discussionId;
        $this->creationDate = $creationDate;
    }
    
    public function getDiscussionId(){
        return $this->discussionId;
    }
    public function setDiscussionId($discussionId){
        $this->discussionId = $discussionId;
    }
    public function getOriginator(){
        return $this->originator;
    }
    public function getText(){
        return $this->text;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
}
