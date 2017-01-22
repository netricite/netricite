<?php
/*
 This is an in-build "magic" method that is automatically called
 by PHP when we output the ToDo objects with echo.
 */

class cTodo {
     public function __toString(){
         // The string we return is outputted by the echo statement
        
         return '
         <li id="todo-'.$this->data['id'].'" class="todo">
        
         <div class="text">'.$this->data['text'].'</div>
        
         <div class="actions">
         <a href="" class="edit">Edit</a>
         <a href="" class="delete">Delete</a>
         </div>
        
         </li>';
     }
}
