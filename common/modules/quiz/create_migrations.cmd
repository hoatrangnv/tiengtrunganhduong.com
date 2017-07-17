php yii my-migrate/create create_quiz_category_table --fields="name:string:notNull:unique,slug:string:notNull:unique,description:string(511),meta_title:string,meta_description:string(511),meta_keywords:string(511),sort_order:integer,active:integer,visible:integer,doindex:integer,dofollow:integer,featured:integer,create_time:integer:notNull,update_time:integer:notNull,creator_id:integer:notNull:foreignKey(user),updater_id:integer:notNull:foreignKey(user),image_id:integer:foreignKey,parent_id:integer:foreignKey(quiz_category)"
php yii my-migrate/create create_quiz_table --fields="name:string:notNull:unique,slug:string:notNull:unique,description:string(511),meta_title:string,meta_description:string(511),meta_keywords:string(511),sort_order:integer,active:integer,visible:integer,doindex:integer,dofollow:integer,featured:integer,create_time:integer:notNull,update_time:integer:notNull,publish_time:integer:notNull,creator_id:integer:notNull:foreignKey(user),updater_id:integer:notNull:foreignKey(user),image_id:integer:foreignKey,quiz_category_id:integer:foreignKey(quiz_category)"
php yii my-migrate/create create_quiz_fn_table --fields="name:string:notNull,parameters:string:notNull,body:text:notNull"
php yii my-migrate/create create_quiz_result_table --fields="name:string:notNull,title:string,description:string(511),content:text,priority:integer,canvas_width:integer,canvas_height:integer,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create create_quiz_validator_table --fields="name:string:notNull,validation_fn_args:text:notNull,quiz_validation_fn_id:integer:notNull:foreignKey(quiz_fn),quiz_id:integer:foreignKey"
php yii my-migrate/create create_quiz_filter_table --fields="name:string:notNull,condition_fn_args:text:notNull,quiz_condition_fn_id:integer:notNull:foreignKey(quiz_fn),quiz_id:integer:foreignKey"
php yii my-migrate/create create_quiz_param_table --fields="name:string:notNull,var_name:string:notNull,value_fn_args:text:notNull,quiz_value_fn_id:integer:notNull:foreignKey(quiz_fn),global_exec_order:integer:notNull,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create create_quiz_character_table --fields="name:string:notNull,var_name:string:notNull,type:string:notNull,index:integer:notNull,global_exec_order:integer:notNull,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create create_quiz_character_medium_table --fields="name:string:notNull,var_name:string:notNull,type:string:notNull,index:integer:notNull,global_exec_order:integer:notNull,quiz_character_id:integer:notNull:foreignKey(quiz_character)"
php yii my-migrate/create create_quiz_input_group_table --fields="name:string:notNull,title:string,global_exec_order:integer:notNull,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create create_quiz_input_table --fields="var_name:string:notNull,type:string:notNull,question:text,hint:text,row:integer,column:integer,quiz_input_group_id:integer:notNull:foreignKey(quiz_input_group)"
php yii my-migrate/create create_quiz_input_option_table --fields="value:string:notNull,content:text,score:integer,interpretation:text,row:integer,column:integer,quiz_input_id:integer:notNull:foreignKey(quiz_input)"
php yii my-migrate/create create_quiz_shape_table --fields="name:string:notNull,text:string,image_id:integer:foreignKey,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create create_quiz_style_table --fields="name:string:notNull,z_index:integer,opacity:integer,top:string,left:string,width:string,height:string,max_width:string,max_height:string,padding:string,background_color:string,border_color:string,border_width:string,border_radius:string,font:string,line_height:string,text_color:string,text_align:string,text_stroke_color:string,text_stroke_width:string,quiz_id:integer:foreignKey"
php yii my-migrate/create create_quiz_sorter_table --fields="name:string:notNull,rule_fn_args:text:notNull,quiz_rule_fn_id:integer:notNull:foreignKey(quiz_fn),quiz_id:integer:foreignKey"

//php yii my-migrate/create create_quiz_input_option_to_result_poll_table --fields="votes:integer:notNull,quiz_result_id:integer:notNull:foreignKey(quiz_result),quiz_input_option_id:integer:notNull:foreignKey(quiz_input_option)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_input_option_and_quiz_voted_result_for_quiz_input_option_and_quiz_result_tables --fields="votes:integer:notNull"
//php yii my-migrate/create create_quiz_shape_to_style_table --fields="style_order:integer,quiz_shape_id:integer:notNull:foreignKey(quiz_shape),quiz_style_id:integer:notNull:foreignKey(quiz_style)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_shape_and_quiz_style_for_quiz_shape_and_quiz_style_tables --fields="style_order:integer:notNull"
//php yii my-migrate/create create_quiz_character_medium_to_style_table --fields="style_order:integer,quiz_character_medium_id:integer:notNull:foreignKey(quiz_character_medium),quiz_style_id:integer:notNull:foreignKey(quiz_style)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_character_medium_and_quiz_style_for_quiz_character_medium_and_quiz_style_tables --fields="style_order:integer:notNull"
//php yii my-migrate/create create_quiz_result_to_shape_table --fields="quiz_result_id:integer:notNull:foreignKey(quiz_result),quiz_shape_id:integer:notNull:foreignKey(quiz_shape)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_result_and_quiz_shape_for_quiz_result_and_quiz_shape_tables
//php yii my-migrate/create create_quiz_result_to_character_medium_table --fields="quiz_result_id:integer:notNull:foreignKey(quiz_result),quiz_character_medium_id:integer:notNull:foreignKey(quiz_character_medium)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_result_and_quiz_character_medium_for_quiz_result_and_quiz_character_medium_tables
//php yii my-migrate/create create_quiz_result_to_shape_to_style_table --fields="style_order:integer,quiz_result_to_shape_id:integer:notNull:foreignKey(quiz_result_to_shape),quiz_style_id:integer:notNull:foreignKey(quiz_style)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_result_to_shape_and_quiz_style_for_quiz_result_to_shape_and_quiz_style_tables --fields="style_order:integer:notNull"
//php yii my-migrate/create create_quiz_result_to_character_medium_to_style_table --fields="style_order:integer,quiz_result_to_character_medium_id:integer:notNull:foreignKey(quiz_result_to_character_medium),quiz_style_id:integer:notNull:foreignKey(quiz_style)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_result_to_character_medium_and_quiz_style_for_quiz_result_to_character_medium_and_quiz_style_tables --fields="style_order:integer:notNull"
//php yii my-migrate/create create_quiz_character_medium_to_sorter_table --fields="sorter_order:integer,quiz_character_medium_id:integer:notNull:foreignKey(quiz_character_medium),quiz_sorter_id:integer:notNull:foreignKey(quiz_sorter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_character_medium_and_quiz_sorter_for_quiz_character_medium_and_quiz_sorter_tables --fields="sorter_order:integer:notNull"
//php yii my-migrate/create create_quiz_character_to_sorter_table --fields="sorter_order:integer,quiz_character_id:integer:notNull:foreignKey(quiz_character),quiz_sorter_id:integer:notNull:foreignKey(quiz_sorter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_character_and_quiz_sorter_for_quiz_character_and_quiz_sorter_tables --fields="sorter_order:integer:notNull"
//php yii my-migrate/create create_quiz_input_to_validator_table --fields="quiz_input_id:integer:notNull:foreignKey(quiz_input),quiz_validator_id:integer:notNull:foreignKey(quiz_validator)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_input_and_quiz_validator_for_quiz_input_and_quiz_validator_tables

//php yii my-migrate/create create_quiz_to_result_filter_table --fields="quiz_id:integer:notNull:foreignKey,quiz_result_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_and_quiz_result_filter_for_quiz_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_to_input_group_filter_table --fields="quiz_id:integer:notNull:foreignKey,quiz_input_group_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_and_quiz_input_group_filter_for_quiz_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_to_character_filter_table --fields="quiz_id:integer:notNull:foreignKey,quiz_character_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_and_quiz_character_filter_for_quiz_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_result_to_character_medium_filter_table --fields="quiz_result_id:integer:notNull:foreignKey(quiz_result),quiz_character_medium_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_result_and_quiz_character_medium_filter_for_quiz_result_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_result_to_shape_filter_table --fields="quiz_result_id:integer:notNull:foreignKey(quiz_result),quiz_shape_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_result_and_quiz_shape_filter_for_quiz_result_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_input_group_to_input_filter_table --fields="quiz_input_group_id:integer:notNull:foreignKey(quiz_input_group),quiz_input_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_input_group_and_quiz_input_filter_for_quiz_input_group_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_input_to_input_option_filter_table --fields="quiz_input_id:integer:notNull:foreignKey(quiz_input),quiz_input_option_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_input_and_quiz_input_option_filter_for_quiz_input_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_character_to_filter_table --fields="quiz_character_id:integer:notNull:foreignKey(quiz_character),quiz_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_character_and_quiz_filter_for_quiz_character_and_quiz_filter_tables
//php yii my-migrate/create create_quiz_character_medium_to_filter_table --fields="quiz_character_medium_id:integer:notNull:foreignKey(quiz_character_medium),quiz_filter_id:integer:notNull:foreignKey(quiz_filter)"
php yii my-migrate/create --migrationPath="@quiz/migrations" create_junction_quiz_character_medium_and_quiz_filter_for_quiz_character_medium_and_quiz_filter_tables


