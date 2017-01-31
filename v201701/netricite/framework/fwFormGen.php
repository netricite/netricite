<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * Helper Form,
 * Form generator
 */
class fwFormGen extends fw\fwObject
{

    private $data;
    // data to be displayed in the form
    private $errors;
    // errors given by validator
    private $lang;
    // errors given by validator
    
    /**
     * constructor
     *
     * @param array $data
     *            data to be displayed in the form
     */
    public function __construct($data = array())
    {
        parent::__construct();
        // trace(debug_backtrace(), $data);
        $this->logger->addDebug("attributes: " . json_encode($data), debug_backtrace());
        
        $this->setData($data);
        $this->setErrors(null);
    }

    /**
     * initialize BS form with data
     *
     * @param array $data
     *            list of fields
     */
    function setData($data)
    {
        $this->data = $data;
    }

    /**
     * set an error associated to one field (validator)
     *
     * @param array $errors
     *            list of errors
     */
    function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * get an error associated to one field (validator)
     *
     * @param array $field
     *            list of fields in the form
     * @return string
     */
    function getError($field)
    {
        if (isset($this->errors[$field])) {
            return '<span class="userMessage">' . $this->errors[$field] . '</span>';
        } else {
            return '';
        }
    }

    /**
     * BS Form
     *
     * @param string $formclass
     *            : BS class
     * @param int $col
     *            : #column
     * @param array $param
     *            : attributes of the form
     * @param array $data
     *            : data to fill in the form
     * @return string html statement
     */
    function formbegin($attributes = array(), $request = array(), $record = array())
    {
        extract($attributes); // get all form attributes
        $formclass = (empty($formclass)) ? '' : "class='" . $formclass . "'";
        $name = (empty($name)) ? $application : $name;
        // $col=(!empty($col)) ? $col : "12";
        
        extract($request); // get all variables of the request
        $urlparam = (! empty($action)) ? $urlparam : '';
        
        $this->setData($record); // set the record value
        
        $html = "<form " . $formclass . " name='$name' role='form' action='index.php?application=" . $application . "&class=" . $class . $urlparam . "' method='post' enctype='multipart/form-data'>";
        $html .= $this->divbegin("", "form-group");
        $html .= empty($legend) ? "" : "<fieldset><legend>" . $this->translate($name, 'legend', $legend) . " </legend>";
        return $html;
    }

    /**
     *
     * @param
     *            string grid class
     * @return string html statement
     */
    function formend()
    {
        return $this->rowend() . "</form>";
    }

    /**
     * begin of BS row block
     *
     * @param
     *            string div class
     * @return string html statement
     */
    function rowbegin($col = "")
    {
        if ($col != "") {
            // $html='<div class="row" col-xs-'.$col.' col-sm-'.$col.'">';
            $html = '<div class="row">'; // col is only for fields inside
        } else
            $html = '<div class="row">';
        return $html;
    }

    /**
     * begin of BS div block
     *
     * @param
     *            string div class
     * @return string html statement
     */
    // function divbegin($col="", $class="form-group"){
    function divbegin($col = "", $class = "")
    {
        $class = (empty($class)) ? '' : $class;
        $col = (empty($col)) ? '' : " col-xs-" . $col . " col-sm-" . $col;
        if (empty($col) && empty($class)) {
            $html = '<div>';
        } else
            $html = '<div class="' . $class . $col . '">';
        return $html;
    }

    /**
     * end of div block
     *
     * @return string html statement
     */
    function inputend($field, $errortext = "")
    {
        $html = '<span class="userMessage">' . $this->translate($field, "errortext", $errortext) . $this->getError($field) . '</span>';
        return $html . $this->divend();
    }

    /**
     * end of row block
     *
     * @return string html statement
     */
    function divend($col = "1")
    {
        $html = '';
        for ($i = 0; $i < $col; $i ++) {
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * end of row block
     *
     * @return string html statement
     */
    function rowend()
    {
        return '</div>';
    }

    /**
     * content of a field
     *
     * @param string $field
     *            index of the field in the data array
     * @return string value
     */
    function value($field)
    {
        $field = empty($field) ? "" : htmlutf8($this->data[$field]);
        return $field;
        /*
         * if (empty($field)) {
         * return "";
         * }
         * return htmlutf8($this->data[$field]);
         */
    }

    /**
     * array of attributes
     *
     * @param
     *            array list of attributes
     *            * @return string html statement
     */
    function attributes($attributes = array(), $tooltip = "")
    {
        $option = '';
        foreach ($attributes as $k => $v) {
            $option .= ' ' . $k . '="' . $v . '"';
        }
        $option .= empty($tooltip) ? "" : " data-toggle='tooltip' title='  $tooltip  ' ";
        return $option;
    }

    /**
     * basic label
     *
     * @param
     *            string label text
     * @return string html statement
     */
    function label($field, $label)
    {
        $label = (! empty($label)) ? $label : $field;
        return '<label for="' . $field . '">' . ucfirst($this->translate($field, "label", $label)) . '</label>';
    }

    /**
     * basic text input type
     *
     * @param string $field            
     * @param string $label            
     * @param array $attributs            
     * @return string html statement
     */
    function base_input($attributes = array())
    {
        $html = "";
        $tootip = "";
        $option = "";
        $label = "";
        $placeholder = "";
        $attr = array(); // default empty
        extract($attributes); // get all input attributes
                              
        // default value
        if (! empty($label)) {
            $html .= $this->label($field, $label);
            $placeholder = (! empty($placeholder)) ? $this->translate($field, "placeholder", $placeholder) : $this->label($field, $label);
        } else {
            $html .= '<label class="sr-only" for="' . $field . '">no label</label>'; // bootstarp recommendations
        }
        $class = empty($class) ? "form-control" : $class;
        
        $tooltip = empty($tooltip) ? "" : $this->translate($field, "tooltip", $tooltip);
        $option .= $this->attributes($attr, $tooltip); // get other attributes
        
        $type = (! empty($type)) ? $type : "text";
        switch ($type) {
            case "text":
            case "password":
                $id = (! empty($id)) ? $id : $field;
                break;
            default:
                $id = $type;
                $type = "text";
                break;
        }
        
        $html .= '<input class="' . $class . '" type="' . $type . '" id="' . $id . '" value="' . $this->value($field) . '" 
             placeholder="' . $this->translate($field, "placeholder", $placeholder) . '" name="data[' . $field . ']" ' . $option . '  />';
        return $html;
    }

    function group_input($attributes = array())
    {
        $col = "";
        $html = "";
        extract($attributes); // get all input attributes
        
        $html .= $this->divbegin($col);
        $html .= $this->base_input($attributes);
        return $html;
    }

    function input($attributes = array())
    {
        $col = "";
        $html = "";
        extract($attributes); // get all input attributes
        if (empty($icon)) {
            // input
            $html .= $this->group_input($attributes);
        } else {
            // input with icon
            $html .= $this->divbegin($col, "input-group");
            $html .= '<span class="input-group-addon"><i class="glyphicon glyphicon-' . $icon . '"></i></span>';
            $html .= $this->base_input($attributes);
        }
        $errortext = (! empty($errortext)) ? $errortext : ""; // default no errortext
        $html .= $this->inputend($field, $errortext);
        return $html;
    }

    function inputDate($attributes = array())
    {
        $html = "";
        $attr = array(); // default empty
        $index = "";
        $tooltip = "";
        $option = "";
        extract($attributes); // get element attributes
        $col = (! empty($col)) ? $col : "6"; // default size
        
        if (empty($icon)) {
            $html .= $this->divbegin($col);
            if (! empty($label)) {
                $html .= $this->label($field, $label);
                $placeholder = (! empty($placeholder)) ? $this->translate($field, "placeholder", $placeholder) : $this->label($field, $label);
            }
        }
        
        $class = empty($class) ? "form-control datepicker" : "datepicker " . $class;
        
        $tooltip = $this->translate($field, "tooltip", $tooltip);
        $option .= $this->attributes($attr, $tooltip); // get other attributes
        
        if (! empty($icon)) {
            $html = $this->divbegin($col, "input-group");
            $html .= '<span class="input-group-addon"><i class="glyphicon glyphicon-' . $icon . '"></i></span>';
        }
        $html .= '<input class="' . $class . '" type="text" id="datepicker" value="' . $this->value($field) . '" name="data[' . $field . ']" ' . $option . ' />';
        $errortext = empty($errortext) ? "" : $errortext;
        $html .= $this->inputend($field, $errortext);
        return $html;
    }

    /**
     * basic text input type
     *
     * @param string $field            
     * @param string $label            
     * @param array $attributs            
     * @return string html statement
     */
    function textarea($attributes = array())
    {
        $html = "";
        $col = "";
        $tooltip = "";
        $option = "";
        $attr = array(); // default empty
        extract($attributes); // get all attributes
        
        $class = (! empty($class)) ? $class : "form-group"; // default class
        $html .= $this->divbegin($col, $class);
        if (! empty($label)) {
            $html .= $this->label($field, $label);
            $placeholder = (! empty($placeholder)) ? $this->translate($field, "placeholder", $placeholder) : $this->label($field, $label);
        }
        $tooltip = $this->translate($field, "tooltip", $tooltip);
        $option .= $this->attributes($attr, $tooltip); // get other attributes
        $option .= ' rows="4"  cols="80"'; // textarea size
        
        $html .= '<textarea class="form-control" id="' . $field . '" placeholder="' . $placeholder . '" name="data[' . $field . ']" ' . $option . '/>';
        $html .= $this->value($field) . "</textarea>";
        $html .= $this->inputend($field);
        return $html;
    }

    /**
     * basic hidden input type
     *
     * @param string $field            
     * @param string $value            
     * @return string html statement
     */
    function hiddenNodata($field, $value)
    {
        $html = '<input type="hidden" value="' . $value . '" name="' . $field . '" />'; // no need to unset
        return $html;
    }

    function hiddenData($field, $value)
    {
        return $this->hiddenNodata("data[" . $field . "]", $this->value($field));
    }

    function hidden($field, $value)
    {
        return $this->hiddenNodata("data[" . $field . "]", $value);
    }

    /**
     * basic button
     *
     * @param string $field
     *            field name
     * @param string $col
     *            #bootstrap colums
     * @param string $icon
     *            icon on the button
     * @param string $class
     *            button class
     * @param string $value
     *            button value
     * @return string html statement
     */
    function button($attributes = array())
    {
        $html = "";
        $attr = array(); // default empty
        $option = "";
        $col = "";
        $tooltip = "";
        extract($attributes);
        
        $html .= $this->divbegin($col);
        
        $class = (! empty($class)) ? $class : "btn btn-primary btn-large pull-right"; // btn btn-default btn-sm
        
        $tooltip = $this->translate($field, "tooltip", $tooltip);
        $option .= $this->attributes($attr, $tooltip); // get other attributes
        $option .= $value = (! empty($value)) ? ' value="' . $value . '"' : "";
        
        $html .= '<button type="submit" id="' . $field . '" name="' . $field . '" class="' . $class . '" ' . $option . ' />';
        $html .= $this->icon($icon, $text);
        $html .= $this->divend();
        return $html;
    }

    function buttonSession($attributes = array())
    {
        $html = "";
        $attr = array(); // default empty
        $value = ""; // default empty
        $text = ""; // default empty
        $col = ""; // default empty
        $tooltip = "";
        extract($attributes);
        
        $tooltip = $this->translate($field, "tooltip", $tooltip);
        if (! empty($_SESSION['pseudo'])) {
            $html .= $this->button(array(
                "field" => $field,
                "col" => $col,
                "icon" => $icon,
                "text" => empty($text) ? "" : $this->translate($field, "text", $text),
                "value" => $value,
                "tooltip" => $tooltip,
                "attr" => $attr
            ));
        } else {
            $html .= $this->button(array(
                "field" => $field,
                "col" => $col,
                "icon" => "ban-circle",
                "class" => "pull-right",
                "text" => empty($text) ? "" : $this->translate($field, "text", $text),
                "value" => $value,
                array(
                    "disabled" => "disabled"
                )
            ));
        }
        return $html;
    }

    function accordionbegin($label)
    {
        $html = "<button class='accordion'>$label</button>";
        $html .= "<div class='panel'>";
        return $html;
    }

    function accordionend()
    {
        $html = "</div>";
        return $html;
    }

    /**
     * basic file input type
     *
     * @param string $field            
     * @param string $label            
     * @return string html statement
     */
    function file($attributes = array())
    {
        $col = "6"; // default col
        $label = "";
        extract($attributes);
        $html = $this->divbegin($col) . $this->label($field, $label);
        $html .= '<input type="file" name="' . $field . '"/>';
        $html .= $this->inputend($field);
        return $html;
    }

    /**
     * basic select input type field
     *
     * @param string $field            
     * @param string $label            
     * @param string $option
     *            select option value=>associated name
     * @return string html statement
     */
    function select($attributes = array())
    {
        $attr = array(); // default empty
        $col = "6"; // default col
        $class = "input-group"; // default class
        extract($attributes);
        
        $html = $this->divbegin($col, $class);
        $html .= '<span class="input-group-addon"><i class="glyphicon glyphicon-' . $icon . '"></i></span>';
        $html .= '<select id="' . $field . '" name="data[' . $field . ']" required/>';
        foreach ($option as $k => $v) {
            if ($k == $this->data[$field]) {
                $html .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
            } else {
                $html .= '<option value="' . $k . '">' . $v . '</option>';
            }
        }
        $html .= '</select>';
        $html .= $this->inputend($field, "sélectionner une option");
        return $html;
    }

    /**
     * basic radio input type field
     *
     * @param string $field            
     * @param string $label            
     * @param string $option
     *            select option value=>associated name
     * @return string html statement
     */
    function radio($attributes = array())
    {
        $attr = array(); // default empty
        $col = "6"; // default col
        $class = "input-group"; // default class
        extract($attributes);
        
        $html = $this->divbegin($col, $class);
        $html .= '<span class="input-group-addon"><i class="glyphicon glyphicon-' . $icon . '"></i></span>';
        $checked = "checked"; // first radio button is checked
        foreach ($option as $k => $v) {
            $html .= '<label class="radio-inline">';
            $html .= '<input type="radio" value="' . $k . '"  name="data[' . $field . ']" ' . $checked . ' />';
            $html .= $v;
            $html .= '</label>';
            $checked = ""; // only first radio button is checked
        }
        $html .= $this->divend();
        return $html;
    }

    /**
     * basic checkbox input type field
     *
     * @param string $field            
     * @param string $label            
     * @param string $option
     *            checkbox list value=>associated name
     * @return string html statement
     */
    function checkbox($class, $field, $label, $option)
    {
        $html = $this->divbegin();
        // $class=(empty($class)) ? $class : "checkbox" . $class;
        if (! is_array($this->data[$field])) {
            $ids = explode(',', $this->data[$field]);
        } else {
            $ids = $this->data[$field];
        }
        foreach ($option as $k => $v) {
            if (in_array($k, $ids)) {
                $html .= '<label class="checkbox' . $class . '"><input type="checkbox" name="data[' . $field . '][]" value="' . $k . '" checked="checked"/> ' . $v;
            } else {
                $html .= '<label class="checkbox' . $class . '"><input type="checkbox" name="data[' . $field . '][]" value="' . $k . '"/> ' . $v;
            }
            $html .= $label . '</label>';
        }
        $html .= $this->divend();
        return $html;
    }

    /**
     * basic image
     *
     * @param string $class            
     * @param unknown $file            
     * @param string $style            
     * @return string html statement
     */
    function image($attributes = array())
    {
        extract($attributes); // get element attributes
                              
        // load options
        $option = "";
        $option .= ! empty($class) ? " class='" . $class . "'" : " class='responsive img-medium'";
        $option .= empty($tooltip) ? "" : " data-toggle='tooltip' title='" . $tooltip . "'";
        
        // file path
        $imgfilePath = ! empty($imgfilePath) ? $imgfilePath : $GLOBALS["application.path"] . $GLOBALS["application.imgsrc"];
        $imgsrcPath = ! empty($imgsrcPath) ? $imgsrcPath : $GLOBALS["application.imgsrc"];
        /*
         * $this->logger->addInfo("image." . json_encode(array(
         * "imgfilePath" => $imgfilePath,
         * "imgsrcPath" => $imgsrcPath,
         * "img" => $file
         * )));
         */
        // scla img
        $boxsize = empty($boxsize) ? 250 : $boxsize;
        $option .= $this->fit_box($imgfilePath . $file, $boxsize);
        
        $attr = (! empty($attr)) ? $attr : array(); // default no attr
        $option .= $this->attributes($attr); // get other attributes
                                             
        // $html = '<img src="public/img/leTraineau/'.$file.'" alt="'.$file.'" '.$style.' />';
        $html = '<img src="' . $imgsrcPath . $file . '" alt="' . $file . '"' . $option . '  /> </a>';
        $html .= empty($sticker) ? "" : '<div class="stickerNew">' . $sticker . ' </div>';
        return $html;
    }

    /**
     * calculate the scale of an image versus the size of the container
     *
     * @param number $box            
     * @param number $x            
     * @param number $y            
     * @return number[]
     */
    function fit_box($filename, $box = 200)
    {
        if (! is_readable($filename))
            throw new \Exception("fwFormGen.fit_box(image file not found) " . $filename);
        list ($x, $y) = getimagesize($filename);
        $scale = min($box / $x, $box / $y, 1);
        $width = round($x * $scale, 0);
        $height = round($y * $scale, 0);
        $html = " style='width:" . $width . "px;height:" . $height . "px'"; // style="width:304px;height:228px"
        /*
         * var_dump($box);
         * var_dump($x, $y);
         * var_dump($scale);
         * var_dump($html);
         */
        return $html;
    }

    /**
     * image with a link and tooltip
     *
     * @param url $index
     *            url of the link
     * @param string $file
     *            image file
     * @param string $tooltip            
     * @return string html statement
     */
    function imageHref($attributes = array())
    {
        extract($attributes); // get element attributes
        
        $html = '<a href="' . $index . '" >';
        $this->image($attributes);
        // $html .= '<img src="' .$GLOBALS["application.imgsrc"].$file. '" alt="'.$file.'"' .$option. ' /> </a>';
        return $html;
    }

    /**
     * icon - glyphicon
     *
     * @param
     *            string glyphicon type
     */
    function icon($icon, $text)
    {
        $html = "";
        $text = empty($text) ? "" : "&nbsp;" . $text . "&nbsp";
        if (isset($icon)) {
            $html = "<span class='glyphicon glyphicon-" . $icon . "'>" . $text . "</span>";
        } else {
            $html .= "<span>" . $text . "</span>";
        }
        
        return $html . '</button>';
    }

    /**
     * icon with a link and tooltip
     *
     * @param unknown $index            
     * @param unknown $icon            
     * @param unknown $tooltip            
     * @param unknown $legend            
     * @return string
     */
    function iconHref_obsolete($index, $icon, $tooltip, $legend = "", $id = "", $class = "")
    {
        $html = '<a href="' . $index . '" data-toggle="tooltip" title="' . $tooltip . '">';
        $id = empty($id) ? "" : "id=" . $id;
        $class = empty($class) ? "" : "class=" . $class;
        $html .= '<span ' . $id . ' class="glyphicon glyphicon-' . $icon . '" >' . $legend . '</span> </a>';
        return $html;
    }

    function iconHref($attributes)
    {
        extract($attributes); // get element attributes
        $id = empty($id) ? "" : "id=" . $id;
        $class = empty($class) ? "" : "class='" . $class . "'";
        $html = '<a href="' . $index . '" data-toggle="tooltip" title="' . $tooltip . '" ' . $class . '>';
        $html .= '<span ' . $id . ' class="glyphicon glyphicon-' . $icon . '" ><span>' . $legend . '</span></span> </a>';
        return $html;
    }

    /**
     * basic caption
     *
     * @param string $title            
     * @param string $legend            
     * @return string
     */
    function caption($title = "", $legend = "")
    {
        $html = '<div class="caption"><p><strong>' . $title . '</strong></p>';
        $html .= $legend;
        $html .= $this->divend();
        return $html;
    }

    /**
     * background(hover) image link
     *
     * @param string $col            
     * @param string $file            
     * @param string $legend            
     * @param string $index            
     * @param string $link            
     * @return string html statement
     */
    function imageLink($attributes = array())
    {
        $sticker = "";
        extract($attributes); // get element attributes
        
        $html = "<li>" . $this->divbegin($col);
        $html .= $this->image(array(
            "class" => "img-pic",
            "file" => $file,
            "sticker" => $sticker
        ));
        $html .= '<ul class="img-info">' . "<li>" . $legend . "</li>";
        $html .= '<li><a   href="' . $index . '" >' . $link . '</a></li>';
        $html .= '</ul>' . $this->divend() . '</li>';
        return $html;
    }

    /**
     * background(hover) cart link
     *
     * @param string $col            
     * @param string $class            
     * @param string $file            
     * @param string $id            
     * @param string $product            
     * @param string $price            
     * @return string html statement
     */
    function imageCart($attributes = array())
    {
        $sticker = "";
        extract($attributes);
        $html = $this->imageThumbnailBegin($attributes);
        // $attributes["legend"]= $this->iconHref('index.php?application=shop&class=cart&action=add&id=' .$id, "shopping-cart", "Ajouter au panier", $legend, "addToCart" );
        $attributes["legend"] = $this->iconHref(array(
            'index' => 'netricite/async/cartAdd.php?id=' . $id,
            'icon' => "shopping-cart",
            'tooltip' => "Ajouter au panier",
            'legend' => $legend,
            'class' => "addToCart"
        ));
        // $this->logger->addInfo("imageCart." . json_encode($attributes));
        $html .= $this->imageThumbnailEnd($attributes);
        return $html;
    }

    /**
     * image in a thumbnail
     *
     * @param string $tab            
     * @param string $file            
     * @param string $title            
     * @param string $legend            
     * @return string html statement
     */
    function imageThumbnail($attributes = array())
    {
        extract($attributes); // get element attributes
        $html = $this->imageThumbnailBegin($attributes);
        $html .= $this->imageThumbnailEnd($attributes);
        return $html;
    }

    function imageThumbnailBegin($attributes = array())
    {
        $sticker = "";
        extract($attributes); // get element attributes
        $col = (! empty($col)) ? $col : ""; // default no col
        $html = $this->divbegin($col) . $this->divbegin("", "thumbnail");
        
        if (empty($attributes["class"])) {
            $attributes["class"] = 'responsive img-thumbnail';
        }
        
        $html .= $this->image($attributes);
        // $html .= $this->image("responsive img-thumbnail",$file, 'style="width:304px;height:228px;"');
        return $html;
    }

    function imageThumbnailEnd($attributes = array())
    {
        extract($attributes); // get element attributes
        
        $html = $this->caption($title, $legend);
        $html .= $this->divend("2");
        return $html;
    }

    /**
     * list of array elements (no bullet)
     *
     * @param array $fields            
     * @return string html statement
     */
    function listUl($fields = array())
    {
        $html = "<ul style='list-style-type:none'>";
        foreach ($fields as $field) {
            $html .= '<li>' . $field . '</li>';
        }
        ;
        $html .= '</ul>';
        return $html;
    }

    /**
     * translate tag
     *
     * @param unknown $fields            
     * @param unknown $tag            
     * @return unknown
     */
    function translate($fields, $tag, $default)
    {
        $html = ucfirst(fw\fwConfigLanguage::get($fields . "." . $tag, $default));
        return $html;
    }
}