<?php
namespace Form\Type;

use Form\GenericFormElement;

class Input extends GenericFormElement {
    public function render() {
        return sprintf(
            '<input type="%s" %s value="%s" name="form[%s]"/>',
            $this->type,
            $this->isRequired() ? 'required="required"' : '',
            $this->getValue(),
            $this->getName(),
        );
    }
}
?>