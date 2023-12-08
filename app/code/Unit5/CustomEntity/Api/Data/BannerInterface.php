<?php
namespace Unit5\CustomEntity\Api\Data;

interface BannerInterface
{
    public function getId();
    public function setId($id);
    public function getLinkImage();
    public function setLinkimg($linkimg);
    public function getDescription();
    public function setDescription($des);
}