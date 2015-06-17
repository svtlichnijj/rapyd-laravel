<?php namespace Zofe\Rapyd\DataForm\Field;


use Illuminate\Html\FormFacade as Form;
use Zofe\Rapyd\Rapyd;
class Redactor extends Field
{
  public $type = "text";

  public function build()
  {
    $output = "";
    if (parent::build() === false) return;

    switch ($this->status) {
      case "disabled":
      case "show":

        if ($this->type =='hidden' || $this->value == "") {
          $output = "";
        } elseif ( (!isset($this->value)) ) {
          $output = $this->layout['null_label'];
        } else {
          $output = nl2br(htmlspecialchars($this->value));
        }
        $output = "<div class='help-block'>".$output."&nbsp;</div>";
        break;

      case "create":
      case "modify":

        Rapyd::js('tinymce/tinymce.min.js');
        $output  = Form::textarea($this->name, $this->value, $this->attributes);
        Rapyd::script("tinymce.init({selector: '".$this->name."'});");

        break;

      case "hidden":
        $output = Form::hidden($this->name, $this->value);
        break;

      default:;
    }
    $this->output = "\n".$output."\n". $this->extra_output."\n";
  }

}
