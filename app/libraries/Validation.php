<?php

class Validation
{
    private $_passed = false, $_errors = [], $_db = null;

    public function __construct()
    {
    }

    /**
     * check($_POST, [
     *          'fname' => [
     *             'display' => 'First Name',
     *            'required' => true
     *       ]]);
     */
    public function check($source, $items = [])
    {
        $this->_errors = [];
        foreach ($items as $item => $rules) {
            $item = Input::sanitize($item);
            $display = $rules['display'];
            foreach ($rules as $rule => $rule_value) {
                $value = Input::sanitize(trim($source[$item]));
                if ($rule === 'required' && empty($value)) {
                    $this->addError(["{$display} is required", $item]);
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError(["{$display} must be minimum of {$rule_value} characters", $item]);
                            }
                            break;

                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError(["{$display} must be maximum of {$rule_value} characters", $item]);
                            }
                            break;

                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $matchDisplay = $items[$rule_value]['display'];
                                $this->addError(["{$matchDisplay} and {$display} must match.", $item]);
                            }
                            break;

                        case 'is_numeric':
                            if (!is_numeric($value)) {
                                $this->addError(["{$display} has to be  a number. Please use a numeric value", $item]);
                            }
                            break;

                        case 'is_positive':
                            if ($value < 0) {
                                $this->addError(["{$display} has to be  a Positive number.", $item]);
                            }
                            break;

                        case 'valid_email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError(["{$display} must be valid email address", $item]);
                            }
                            break;

                        case 'alphabetic':
                            $pattern = '/^[a-zA-Z ]*$/';
                            if (!preg_match($pattern, $value)) {
                                $this->addError("{$display} Only use alphabets and white space. E.g. John Doe");
                            }
                            break;

                        
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    public function addError($error)
    {
        $this->_errors[] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }

    public function displayErrors()
    {
        $html = '<ul>';
        foreach ($this->_errors as $error) {
            if (is_array($error)) {
                $html .= '<li>' . $error[0] . '</li>';
            } else {
                $html .= '<li>' . $error . '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
