<?php

namespace app\traits;

interface IActiveStatus
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVE = -1;
}

trait StatusTrait
{
    public static function getStatusList()
    {
        return [
            IActiveStatus::STATUS_INACTIVE => 'STATUS_INACTIVE',
            IActiveStatus::STATUS_ACTIVE => 'STATUS_ACTIVE',
            IActiveStatus::STATUS_ARCHIVE => 'STATUS_DELETED'
        ];
    }

    public function getStatusList2()
    {
        return self::getStatusList();
    }

    public function getStatus($nullLabel = '')
    {
        $statuses = static::getStatusList();
        return (isset($this->status) && isset($statuses[$this->status])) ? $statuses[$this->status] : $nullLabel;
    }
}
