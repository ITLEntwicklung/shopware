<?php declare(strict_types=1);

namespace Shopware\Framework\Write\Resource;

use Shopware\Framework\Write\Field\IntField;
use Shopware\Framework\Write\Field\StringField;
use Shopware\Framework\Write\Flag\Required;
use Shopware\Framework\Write\Resource;

class CampaignsContainersResource extends Resource
{
    protected const PROMOTIONID_FIELD = 'promotionID';
    protected const VALUE_FIELD = 'value';
    protected const TYPE_FIELD = 'type';
    protected const DESCRIPTION_FIELD = 'description';
    protected const POSITION_FIELD = 'position';

    public function __construct()
    {
        parent::__construct('s_campaigns_containers');

        $this->fields[self::PROMOTIONID_FIELD] = new IntField('promotionID');
        $this->fields[self::VALUE_FIELD] = (new StringField('value'))->setFlags(new Required());
        $this->fields[self::TYPE_FIELD] = (new StringField('type'))->setFlags(new Required());
        $this->fields[self::DESCRIPTION_FIELD] = (new StringField('description'))->setFlags(new Required());
        $this->fields[self::POSITION_FIELD] = new IntField('position');
    }

    public function getWriteOrder(): array
    {
        return [
            \Shopware\Framework\Write\Resource\CampaignsContainersResource::class,
        ];
    }

    public static function createWrittenEvent(array $updates, array $errors = []): \Shopware\Framework\Event\CampaignsContainersWrittenEvent
    {
        $event = new \Shopware\Framework\Event\CampaignsContainersWrittenEvent($updates[self::class] ?? [], $errors);

        unset($updates[self::class]);

        if (!empty($updates[\Shopware\Framework\Write\Resource\CampaignsContainersResource::class])) {
            $event->addEvent(\Shopware\Framework\Write\Resource\CampaignsContainersResource::createWrittenEvent($updates));
        }

        return $event;
    }
}