<?php
namespace Classes\Form\Type;

use Classes\Form\GenericFormElement;

class Input extends GenericFormElement {
    public function render() {

        $html = sprintf('<label>%s</label><br>', $this->getName());

        $html .= sprintf(
            '<input type="%s" %s value="%s" name="form[%s]"/>',
            $this->type,
            $this->isRequired() ? 'required="required"' : '',
            $this->getValue(),
            $this->getName(),
        );
        return $html;
    }

    public function getName(): string {
        return $this->name;
    }
}
?>