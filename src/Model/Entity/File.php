<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity.
 *
 * @property int $id
 * @property string $number
 * @property \Cake\I18n\Time $startDate
 * @property bool $canceled
 * @property int $client_id
 * @property \App\Model\Entity\Client $client
 * @property int $input_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Input $input
 * @property \App\Model\Entity\Document[] $documents
 * @property \App\Model\Entity\Lot[] $lots
 * @property \App\Model\Entity\Output[] $outputs
 */
class File extends Entity
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
