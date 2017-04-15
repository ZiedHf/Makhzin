<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Client Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $matriculeFiscale
 * @property string $code
 * @property bool $approved
 * @property string $adress
 * @property string $email1
 * @property string $email2
 * @property string $email3
 * @property string $tel1
 * @property string $tel2
 * @property string $tel3
 * @property string $fax1
 * @property string $fax2
 * @property string $fax3
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\File[] $files
 */
class Client extends Entity
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
