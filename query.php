<?php
$trialBalance = "
    CREATE OR REPLACE VIEW view_trial_balance AS SELECT
    `tbl_account_transactions`.`voucher_type` as `voucher_type`,
    `tbl_account_transactions`.`voucher_no` as `voucher_no`,
    `tbl_account_transactions`.`voucher_date` as `voucher_date`,
    `tbl_account_transactions`.`coa_head_code` as `coa_head_code`,
    `tbl_account_transactions`.`debit_amount` as `debit_amount`,
    `tbl_account_transactions`.`credit_amount` as `credit_amount`,
    `tbl_coa`.`transaction` as `transaction`,
    `tbl_coa`.`general_ledger` as `general`,
    `tbl_coa`.`parent_head_name` as `parent_head_name`,
    `tbl_coa`.`head_type` as `head_type`,
    `tbl_coa`.`head_name` as `head_name`
    FROM `tbl_account_transactions`
    LEFT JOIN `tbl_coa` ON `tbl_coa`.`head_code` = `tbl_account_transactions`.`coa_head_code` WHERE `tbl_account_transactions`.`approve` = 1
    ";
