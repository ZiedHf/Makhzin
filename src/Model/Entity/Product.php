<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $productCode
 * @property string $ngpCode
 * @property string $barCode
 * @property bool $subjectToQuota
 * @property float $quota
 * @property float $tolerance
 * @property bool $approved
 * @property string $emballage
 * @property float $unitQte
 * @property string $unit
 * @property int $stock_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Stock[] $stocks
 * @property \App\Model\Entity\Association[] $associations
 * @property \App\Model\Entity\Lot[] $lots
 */
class Product extends Entity
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
