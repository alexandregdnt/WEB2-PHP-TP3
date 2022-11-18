<?php

namespace App\Types;

enum HttpMethods {
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
    case OPTIONS;
}
