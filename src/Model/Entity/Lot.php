<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lot Entity.
 *
 * @property int $id
 * @property string $number
 * @property \Cake\I18n\Time $deadline
 * @property float $expectedQte
 * @property float $actualQte
 * @property int $product_id
 * @property \App\Model\Entity\Product $product
 * @property int $client_id
 * @property \App\Model\Entity\Client $client
 * @property int $zone_id
 * @property \App\Model\Entity\Zone $zone
 * @property int $input_id
 * @property \App\Model\Entity\Input $input
 * @property int $file_id
 * @property \App\Model\Entity\File $file
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Output[] $outputs
 */
class Lot extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
