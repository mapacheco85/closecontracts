<?php

namespace PHPMaker2021\CloseContracts;

/**
 * Captcha interface
 */
interface CaptchaInterface
{

    public function getHtml();

    public function getConfirmHtml();

    public function validate();

    public function getScript($formName);
}
