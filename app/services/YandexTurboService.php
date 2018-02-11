<?php namespace App\Services;

use Slim\Container;
use sokolnikov911\YandexTurboPages\Channel;
use sokolnikov911\YandexTurboPages\Counter;
use sokolnikov911\YandexTurboPages\Feed;
use sokolnikov911\YandexTurboPages\Item;
use sokolnikov911\YandexTurboPages\RelatedItem;
use sokolnikov911\YandexTurboPages\RelatedItemsList;

class YandexTurboService extends Service
{
    private $channelDataFieldsRequired = ['title', 'link', 'description', 'language', 'pubDate'];
    private $channelData;
    private $itemsData;

    public function __construct(Container $container, $channelData, $itemsData)
    {
        parent::__construct($container);
        $this->channelData = $channelData;
        $this->itemsData = $itemsData;

        $this->validateChannelDataFields($this->channelData);
        $this->validateItems($this->itemsData);
    }

    public function generate()
    {
        $feed = new Feed();
        $channel = new Channel();

        $this->setChannelDescription($feed, $channel);

        foreach ($this->itemsData as $itemData) {
            $this->addItem($channel, $itemData);
        }

        file_put_contents('turbo.xml', $feed);

    }

    private function setChannelDescription(Feed $feed, Channel $channel)
    {
        $channel
            ->title($this->channelData['title'])
            ->link($this->channelData['link'])
            ->description($this->channelData['description'])
            ->language($this->channelData['language'])
            //->adNetwork(Channel::AD_TYPE_YANDEX, 'RA-123456-7', 'first_ad_place')
            ->appendTo($feed);
    }

    private function addItem(Channel $channel, $itemData)
    {
        $item = new Item();
        $item
            ->title($itemData['title'])
            ->link($itemData['link'])
            //->author($itemData['author'])
            ->category($itemData['category'])
            ->turboContent($itemData['turboContent'])
            ->pubDate($itemData['pubDate'])
            ->appendTo($channel);

        $this->addRelated($item, $itemData['related']);
    }

    private function addRelated(Item $item, $relatedItems)
    {
        $relatedItemsList = new RelatedItemsList();

        //$relatedItemsList = new RelatedItemsList();
        foreach ($relatedItems as $relatedItem) {
            $relatedItem = new RelatedItem(
                $relatedItem['title'],
                $relatedItem['link'],
                $relatedItem['img']
            );
            $relatedItem->appendTo($relatedItemsList);
        }

        $relatedItemsList
            ->appendTo($item);

    }

    private function addGoogleCounter(Channel $channel)
    {
        $googleCounter = new Counter(Counter::TYPE_GOOGLE_ANALYTICS, 'XX-1234567-89');
        $googleCounter->appendTo($channel);
    }

    private function addYandexCounter(Channel $channel)
    {
        $yandexCounter = new Counter(Counter::TYPE_YANDEX, 12345678);
        $yandexCounter->appendTo($channel);
    }

    private function validateChannelDataFields($channelData)
    {
        foreach ($this->channelDataFieldsRequired as $field) {
            if (!isset($channelData[$field])) {
                $message = 'Отсутствует поле '. $field . ' в данных о канале';
                throw new \Exception($message, 500);
            }
        }
    }

    private function validateItems($items)
    {
        if(!$items) {
            $message = 'Нет элементов для добавления в Feed';
            throw new \Exception($message, 500);
        }
    }

}
