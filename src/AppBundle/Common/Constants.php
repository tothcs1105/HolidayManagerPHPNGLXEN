<?php

namespace AppBundle\Common;

class Constants
{
    //other
    const USER_KEY = "user";
    const ADMIN_USER_KEY = "admin";
    const TWIG_NOTICE = "notice";
    const DATE_FORMAT = "Y-m-d";
    const FORM_PARAM_VALUE = "form";

    //services
    const USER_SERVICE = "app.userservice";
    const TAKEN_HOLIDAY_SERVICE = "app.takenholidayservice";
    const AVAILABLE_HOLIDAY_SERVICE = "app.availableholidayservice";
    const HOLIDAY_SERVICE = "app.holidayservice";
    const ROLE_SERVICE = "app.roleservice";
}