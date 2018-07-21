php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_category_table --fields="name:string:notNull:unique,slug:string:notNull:unique,description:string(511),meta_title:string,meta_description:string(511),meta_keywords:string(511),sort_order:integer,active:smallInteger(1),visible:smallInteger(1),doindex:smallInteger(1),dofollow:smallInteger(1),featured:smallInteger(1),create_time:integer:notNull,update_time:integer:notNull,creator_id:integer:notNull:foreignKey(user),updater_id:integer:notNull:foreignKey(user),image_id:integer:foreignKey,parent_id:integer:foreignKey(quiz_category)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_table --fields="name:string:notNull:unique,slug:string:notNull:unique,introduction:text,duration:integer,input_answers_showing:string,description:string(511),meta_title:string,meta_description:string(511),meta_keywords:string(511),sort_order:integer,active:smallInteger(1),visible:smallInteger(1),doindex:smallInteger(1),dofollow:smallInteger(1),featured:smallInteger(1),create_time:integer:notNull,update_time:integer:notNull,publish_time:integer:notNull,creator_id:integer:notNull:foreignKey(user),updater_id:integer:notNull:foreignKey(user),image_id:integer:foreignKey,quiz_category_id:integer:foreignKey(quiz_category)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_result_table --fields="name:string:notNull,title:string,description:string(511),content:text,priority:integer,canvas_width:integer:notNull,canvas_height:integer:notNull,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_character_table --fields="name:string:notNull,var_name:string:notNull,type:string:notNull,index:integer:notNull,task_order:integer:notNull,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_character_medium_table --fields="name:string:notNull,var_name:string:notNull,type:string:notNull,index:integer:notNull,task_order:integer:notNull,quiz_character_id:integer:notNull:foreignKey(quiz_character)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_alert_table --fields="name:string:notNull,title:string,message:text:notNull,type:string:notNull,task_order:integer:notNull,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_input_group_table --fields="name:string:notNull,title:string,introduction:text,duration:integer,task_order:integer:notNull,inputs_per_row:integer,inputs_per_small_row:integer,inputs_appearance:string,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_input_table --fields="name:string:notNull,var_name:string:notNull,type:string:notNull,question:text,answer:text,sort_order:integer,options_per_row:integer,options_per_small_row:integer,quiz_input_group_id:integer:notNull:foreignKey(quiz_input_group)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_input_option_table --fields="value:string:notNull,content:text,score:integer,correct:smallInteger(1),explanation:text,sort_order:integer,quiz_input_id:integer:notNull:foreignKey(quiz_input)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_shape_table --fields="name:string:notNull,text:string,image_id:integer:foreignKey,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_style_table --fields="name:string:notNull,z_index:integer,opacity:integer,top:string,left:string,width:string,height:string,max_width:string,max_height:string,padding:string,background_color:string,border_color:string,border_width:string,border_radius:string,font:string,line_height:string,text_color:string,text_align:string,text_stroke_color:string,text_stroke_width:string,quiz_id:integer:foreignKey"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_fn_table --fields="name:string:notNull,description:string(511),parameters:string:notNull,body:text:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_object_filter_table --fields="name:string:notNull,affected_object_type:string:notNull,task_order:integer:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_character_data_filter_table --fields="name:string:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_character_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_character_medium_data_filter_table --fields="name:string:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_character_medium_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_character_data_sorter_table --fields="name:string:notNull,apply_order:integer:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_character_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_character_medium_data_sorter_table --fields="name:string:notNull,apply_order:integer:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_character_medium_id:integer:notNull:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_input_validator_table --fields="name:string:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_id:integer:foreignKey"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_param_table --fields="name:string:notNull,var_name:string:notNull,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,task_order:integer:notNull,quiz_id:integer:notNull:foreignKey"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_junction_quiz_input_option_and_quiz_voted_result_for_quiz_input_option_and_quiz_result_tables --fields="votes:integer:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_junction_quiz_shape_and_quiz_style_for_quiz_shape_and_quiz_style_tables --fields="style_order:integer:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_junction_quiz_character_medium_and_quiz_style_for_quiz_character_medium_and_quiz_style_tables --fields="style_order:integer:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_junction_quiz_result_and_quiz_shape_for_quiz_result_and_quiz_shape_tables
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_junction_quiz_result_and_quiz_character_medium_for_quiz_result_and_quiz_character_medium_tables
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_junction_quiz_input_and_quiz_input_validator_for_quiz_input_and_quiz_input_validator_tables

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_error_message_column_to_quiz_input_validator_table --fields="error_message:string:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_guideline_column_to_quiz_fn_table --fields="guideline:text"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_is_open_question_column_to_quiz_input_table --fields="is_open_question:smallInteger(1)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_width_column_height_column_to_quiz_character_medium_table --fields="width:integer,height:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_type_column_to_quiz_result_table --fields="type:string:notNull"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_case_sensitive_column_to_quiz_input_option_table --fields="case_sensitive:smallInteger(1)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_shuffle_options_column_to_quiz_input_table --fields="shuffle_options:smallInteger(1)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_canvas_background_color_column_to_quiz_result_table --fields="canvas_background_color:string"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_font_family_column_font_size_column_font_weight_column_font_style_column_min_width_column_min_height_column_to_quiz_style_table --fields="font_family:string,font_size:string,font_weight:string,font_style:string,min_width:string,min_height:string"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_view_count_column_like_count_column_comment_count_column_share_count_column_to_quiz_table --fields="view_count:integer:defaultValue(0),like_count:integer:defaultValue(0),comment_count:integer:defaultValue(0),share_count:integer:defaultValue(0)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_async_column_to_quiz_fn_table --fields="async:smallInteger(1)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_repeat_count_column_to_quiz_input_option_table --fields="repeat_count:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_images_per_row_column_images_per_small_row_column_to_quiz_input_table --fields="images_per_row:integer,images_per_small_row:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_shuffle_images_column_to_quiz_input_table --fields="shuffle_images:smallInteger(1)"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_timeout_handling_column_to_quiz_table --fields="timeout_handling:string"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_timeout_handling_column_to_quiz_input_group_table --fields="timeout_handling:string"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_auto_next_column_to_quiz_input_table --fields="auto_next:smallInteger(1)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_quiz_duration_change_column_input_group_duration_change_column_time_speed_change_column_to_quiz_input_option_table --fields="quiz_duration_change:integer,input_group_duration_change:integer,time_speed_change:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_retry_if_incorrect_column_to_quiz_input_table --fields="retry_if_incorrect:smallInteger(1)"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_input_image_table --fields="sort_order:integer,quiz_input_id:integer:notNull:foreignKey,image_id:integer:notNull:foreignKey"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" create_quiz_input_option_checker_table --fields="name:string,arguments:string:notNull,quiz_fn_id:integer:notNull:foreignKey,quiz_input_option_id:integer:notNull:foreignKey"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_required_column_to_quiz_input_table --fields="required:smallInteger(1)"


php yii my-migrate/create --migrationPath="@modules/quiz/migrations" drop_quiz_duration_change_column_input_group_duration_change_column_time_speed_change_column_from_quiz_input_option_table --fields="quiz_duration_change:integer,input_group_duration_change:integer,time_speed_change:integer"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_common_duration_change_column_group_duration_change_column_common_countdown_delay_change_column_group_countdown_delay_change_column_to_quiz_input_option_table --fields="common_duration_change:integer,group_duration_change:integer,common_countdown_delay_change:integer,group_countdown_delay_change:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_countdown_delay_column_to_quiz_table --fields="countdown_delay:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_countdown_delay_column_to_quiz_input_group_table --fields="countdown_delay:integer"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_correct_choices_min_column_incorrect_choices_max_column_to_quiz_input_table --fields="correct_choices_min:integer,incorrect_choices_max:integer"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_showed_stopwatches_column_to_quiz_table --fields="showed_stopwatches:string"



php yii my-migrate/create --migrationPath="@modules/quiz/migrations" drop_is_open_question_column_from_quiz_input_table --fields="is_open_question:smallInteger(1)"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" drop_inputs_per_rows_column_inputs_per_small_rows_column_inputs_appearance_column_from_quiz_input_group_table --fields="inputs_per_row:integer,inputs_per_small_row:integer,inputs_appearance:string"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_input_questions_are_open_column_inputs_appear_simultaneously_column_to_quiz_input_group_table --fields="input_questions_are_open:smallInteger(1),inputs_appear_simultaneously:smallInteger(1)"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_return_type_column_to_quiz_fn_table --fields="return_type:string:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_escape_html_column_to_quiz_table --fields="escape_html:smallInteger(1)"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_image_src_column_to_quiz_shape_table --fields="image_src:text"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_apply_order_column_to_quiz_character_data_filter_table --fields="apply_order:integer:notNull"
php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_apply_order_column_to_quiz_character_medium_data_filter_table --fields="apply_order:integer:notNull"

php yii my-migrate/create --migrationPath="@modules/quiz/migrations" add_exported_play_props_column_to_quiz_table --fields="exported_play_props:text"


php yii my-migrate/create --migrationPath="@modules/quiz/migrations" drop_task_order_column_from_quiz_character_medium_table --fields="task_order:integer:notNull"












