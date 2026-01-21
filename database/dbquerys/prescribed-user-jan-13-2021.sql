alter table nurse_other_iv_drugs
add prescribed_user_id int;

alter table nurse_iv_infusion
add prescribed_user_id int;

alter table nurse_other_iv_infusion
add prescribed_user_id int;

alter table nurse_glucose_intake
add prescribed_user_id int;

alter table nurse_oral_drugs
add prescribed_user_id int;