<?php
/**
 * Created by PhpStorm.
 * User: Asaf
 * Date: 22/03/2015
 * Time: 18:00
 */
class SmsMessage
{
    private $_phoneNumber = "00000";
    private $_templateName = "defaultTemplate.xml";
    private $_templatePath = "http://www.graphene.cf/sms/defaultTemplate.xml";

    public function __construct($phoneNumber = "0000", $templateName = "defaultTemplate.xml",
                                $templatePath = "http://www.graphene.cf/sms/defaultTemplate.xml")
    {
        $this->setPhoneNumber($phoneNumber);
        $this->setTemplateName($templateName);
        $this->setTemplatePath($templatePath);
    }
    public function setPhoneNumber($phoneNumber)
    {
        $this->_phoneNumber = $phoneNumber;
    }

    public function setTemplateName($templateName)
    {
        $this->_templateName = $templateName;
    }

    public function setTemplatePath($templatePath)
    {
        $this->_templatePath = $templatePath;
    }

    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    public function getTemplateName()
    {
        return $this->_templateName;
    }

    public function getTemplatePath()
    {
        return $this->_templatePath;
    }
}
