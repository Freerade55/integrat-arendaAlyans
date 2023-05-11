<?php
require ROOT . "/functions/display-errors.php";
require ROOT . "/vendor/autoload.php";
require ROOT . "/logs/logs.php";
require ROOT . "/functions/connectToCrm.php";
require ROOT . "/functions/refreshToken.php";
require ROOT . "/functions/crmMethods.php";

const
CRM_ENTITY_LEAD = "lead",
CRM_ENTITY_CONTACT = "contact",
CRM_ENTITY_COMPANY = "company",
CRM_PIPELINE_ID = 5444773,
CRM_RESPONSIBLE_ID = 8287501,
CRM_TASK_TYPE_ID = 2794062,
//    статус как статус сделки, тут первичный
CRM_STATUS_ID = 48275173,
CRM_TAG_ID = 557593,


METHOD_POST = "POST",
METHOD_PATCH = "PATCH";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();