/* index for Picasso updates */
ALTER TABLE `user` ADD INDEX( `t_edited`);
ALTER TABLE `user_camp` ADD INDEX( `t_edited`);
ALTER TABLE `event` ADD INDEX( `t_edited`);
ALTER TABLE `event_instance` ADD INDEX( `t_edited`);
ALTER TABLE `event_responsible` ADD INDEX( `t_edited`);
ALTER TABLE `category` ADD INDEX( `t_edited`);
ALTER TABLE `day` ADD INDEX( `t_edited`);
ALTER TABLE `subcamp` ADD INDEX( `t_edited`);

/* index for user search */
ALTER TABLE `user` ADD INDEX( `scoutname`, `firstname`, `surname`, `active`);
ALTER TABLE `user_camp` ADD INDEX( `active`);
ALTER TABLE `user_camp` ADD INDEX( `function_id`);

/* subcamp filtering + day calculation */
ALTER TABLE `subcamp` ADD INDEX( `start`, `length`);

/* job data */
ALTER TABLE `job` ADD INDEX( `show_gp`);

/* dropdown data */
ALTER TABLE `dropdown` ADD INDEX( `list`, `item_nr`, `entry`, `value`);
