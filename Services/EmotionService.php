<?php

namespace OstEmotion\Services;

use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Enlight_Components_Db_Adapter_Pdo_Mysql as Db;

class EmotionService
{

    /**
     * ...
     *
     * @var ContextServiceInterface
     */
    private $contextService;

    /**
     * ...
     *
     * @var Db
     */
    private $db;

    /**
     * ...
     *
     * @param ContextServiceInterface $contextService
     * @param Db $db
     */
    public function __construct(ContextServiceInterface $contextService, Db $db)
    {
        $this->contextService = $contextService;
        $this->db             = $db;
    }

   
    public function get($id = null)
    {
        $query = "
            SELECT
                emotion.*,
                attribute.ost_emotion_forms AS ost_position
            FROM s_emotion AS emotion
                LEFT JOIN s_emotion_shops AS shop
                    ON emotion.id = shop.emotion_id AND shop.shop_id = :shopId
                LEFT JOIN s_emotion_attributes AS attribute
                    ON emotion.id = attribute.emotionID
            WHERE emotion.active = 1
                AND emotion.is_landingpage = 1
                AND shop.id IS NOT NULL
                AND attribute.id IS NOT NULL
                AND ( ( attribute.ost_emotion_forms IS NOT NULL ) AND ( attribute.ost_emotion_forms IN ('1','2','3','4','5') ) )
                AND ( ( valid_from IS NULL ) OR ( ( valid_from IS NOT NULL ) AND ( valid_from < NOW() ) ) )
                AND ( ( valid_to IS NULL ) OR ( ( valid_to IS NOT NULL ) AND ( valid_to > NOW() ) ) )
                AND ( ( attribute.ost_emotion_forms_id = :id ) OR ( attribute.ost_emotion_forms_id IS NULL ) OR ( attribute.ost_emotion_forms_id = '' ) ) 
            GROUP BY emotion.id
            ORDER BY emotion.position ASC, emotion.id DESC
        ";

        $emotion = $this->db->fetchAll(
            $query,
            array_merge(
                array('shopId' => $this->contextService->getShopContext()->getShop()->getId()),
                ((!empty($id)) ? array('id' => $id) : array())
            )
        );
        return $this->hydrate($emotion);
    }

    private function hydrate(array $emotions)
    {
        $arr = [];

        foreach ($emotions as $emotion) {
            $query = "
                SELECT MAX(end_row)
                FROM s_emotion_element_viewports
                WHERE emotionID = ?
                    AND alias = 'xl'
            ";
            $rows = (integer)$this->db->fetchOne($query, array($emotion['id']));

            // and add the id
            array_push(
                $arr,
                array(
                    'id' => $emotion['id'],
                    'height' => ($rows * $emotion['cell_height']) + (($rows - 1) * $emotion['cell_spacing']),
                    'margin' => $emotion['cell_spacing'],
                    'devices' => $emotion['device'],
                    'position' => $emotion['ost_position']
                )
            );
        }

        return $arr;
    }
}
