<?php
header('Content-Type: text/html; charset=utf-8');

const ROOT = __DIR__;

require ROOT . "/functions/require.php";



$data = $_REQUEST;

logs($data);


if(!empty($data["order"]["fields_by_name"]["Номер телефона"])) {

// телефон, имя с формы
    $phone = $data["order"]["fields_by_name"]["Номер телефона"];

    $phone = preg_replace("/[^\d]/siu", "", $phone);
    $phone = preg_replace("/^[8]/", "7", $phone, 1);


    $name = $data["order"]["fields_by_name"]["Имя"];

    $list = null;

    if(!empty($data["order"]["fields_by_name"]["Выпадающий список"])) {

        $list = $data["order"]["fields_by_name"]["Выпадающий список"];

    }



    if(isset($list)) {

        $description = "имя - $name \n телефон - $phone \n техника - $list";

    } else {
        $description = "имя - $name \n телефон - $phone";

    }

    $searchContact = searchEntity(CRM_ENTITY_CONTACT, $phone);




    //    контакт уже есть
    if(!empty($searchContact)) {

        //      айди контакта
        $contactId = $searchContact["_embedded"]["contacts"][0]["id"];
//        ответственный с контакта, в случае если уже есть контакт
        $responsible_user_id = $searchContact["_embedded"]["contacts"][0]["responsible_user_id"];

        $addedLeadId = null;



        //      если есть сделки вообще

        if(!empty($searchContact["_embedded"]["contacts"][0]["_embedded"]["leads"])) {


            $leads = $searchContact["_embedded"]["contacts"][0]["_embedded"]["leads"];

            $activeLeadStatus = null;

            foreach ($leads as $lead) {

// поиск седелок по id
                $getLeadInfo = getEntity(CRM_ENTITY_LEAD, $lead["id"]);


//            проверка на статус сделки
                if($getLeadInfo["status_id"] != 142 && $getLeadInfo["status_id"] != 143) {

                    $activeLeadStatus = true;
                    $addedLeadId = $lead["id"];

                }



            }


//       если нет активных сделок

            if(!isset($activeLeadStatus)) {

                $addLeadRes = addLead($contactId, $responsible_user_id);
                $addedLeadId = $addLeadRes["_embedded"]["leads"][0]["id"];

                addTag("leads", $addedLeadId);




            }




        } else {

            $addLeadRes = addLead($contactId, $responsible_user_id);
            $addedLeadId = $addLeadRes["_embedded"]["leads"][0]["id"];

            addTag("leads", $addedLeadId);


        }


        addNote("contacts", $contactId, $description);

        addTask($addedLeadId, $responsible_user_id);






    } else {

        $addContact = addContact($name, $phone);


        $addLeadRes = addLead($addContact["_embedded"]["contacts"][0]["id"]);
        $addedLeadId = $addLeadRes["_embedded"]["leads"][0]["id"];

        addTag("leads", $addedLeadId);

        addNote("contacts", $addContact["_embedded"]["contacts"][0]["id"], $description);

        addTask($addedLeadId);







    }










}






















