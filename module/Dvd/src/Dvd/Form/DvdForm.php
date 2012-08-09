<?php
namespace Dvd\Form;

use Zend\Form\Form;

class DvdForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('dvd');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'number',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Number',
            ),
        ));
        
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'OK',
                'id' => 'submitbutton',
            ),
        ));

    }
}
