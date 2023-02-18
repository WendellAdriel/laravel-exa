<?php

namespace Exa\Support;

enum ChangeActions: string
{
    case CREATE = 'CREATED';
    case UPDATE = 'UPDATED';
    case DELETE = 'DELETED';
}
