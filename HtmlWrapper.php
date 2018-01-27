<?php

class HtmlWrapper
{
    private $header;

}

class HtmlSection
{
    private $html="";

    public function __construct($section_body)
    {
        $this->html = $section_body;
    }
}