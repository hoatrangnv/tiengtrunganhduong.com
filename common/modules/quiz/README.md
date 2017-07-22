**Step 1: Create quiz model**

Provide a `name` in human-language
...

**Step 2: Create results**


Provide a `name` in human-language

Provide a `title`, `description` and `content` to show for player what result is (optional)

Provide a `priority` to indicate one result will be chosen if there are two or more suiable result (optional)

Provide `canvas_with` and `canvas_height`
    
===============
_The order of step 3, 4, 5, 6 depends on value of their `global_exec_order`_

**Step 3: Create params**

Provide a `name` in human-language

Provide a `var_name`, only contains words, number, underscore, and no starts with number

Provide a `value` as function body, this function has no argument, and must return a value

Provide a `global_exec_order` as a number to indicate the order of execution for this param
	
**Step 4: Create characters**

Provide a `name` in human-language

Provide a `var_name`, only contains words, number, underscore, and no starts with number

Provide a `type` and `index` (with some `filter`s and `sorter`s are optional) for each character to find out a proper one from the run time list

Provide a `global_exec_order` as a number to indicate the order of execution for this character

**Step 5: Create character media**

Provide a `name` in human-language

Provide a `var_name`, only contains words, number, underscore, and no starts with number

Provide a `type` and `index` (with some `filter`s and `sorter`s are optional) for each character to find out a proper one from the run time list

Provide a `global_exec_order` as a number to indicate the order of execution for this character medium

Provide some `style`s to style this medium
	
**Step 6.1: Create input groups**

Provide a `name` in human-language

Provide a `title` for player (optional)

Provide a `global_exec_order` as a number to indicate the order of execution for this input group
	
**Step 6.2: Create inputs for each input group**

Provide a `var_name`, only contains words, number, underscore, and no starts with number

Provide a `type`. Types are consist of text, number, date, datetime, checkbox_group, radio_group, selectbox

Provide some `validator`s to validate input from player (optional)

Provide a `question` for player (optional)

Provide `row` and `column` to indicate position of this input on screen (optional)
	
**Step 6.3: Create input options for each input**

Provide a `value`

Provide a `content`, by default, it will be assigned by `value` (optional)

Provide a `score`, this score will be added to quiz total_score (optional)

Provide some `result_poll`s to vote for proper result (optional)

Provide a `interpretation` to explain with player that why this option true or false, or any other reasons (optional)

Provide `row` and `column` to indicate position of this input on screen (optional)

_This step is required if input type is checkbox_group, radio_group or select_box
In these case, player only can choose one (or more with input type is checkbox_group) option, and validator for input is unnecessary.
If input type is not checkbox_group, radio_group or select_box, these option is not required, but if provided, its still make sense.
That is, if input from player is same with one of these options, score of this option will be added to total_score of quiz.
And via result poll(s), corresponding result will be increase its votes._
    
===============
	
**Step 7: Create shapes**

Provide a `name` in human-language

Provide an `image_id` to refer to image that will be background of this shape (optional)

Provide a `text` to display on this shape (optional)

Provide some `style`s to style this shape

**Step 8: Add shapes and mediums to corresponding results**
