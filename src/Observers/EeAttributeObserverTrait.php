<?php

/**
 * TechDivision\Import\Product\Ee\Observers\EeProductAttributeObserverTrait
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Ee\Observers;

use TechDivision\Import\Ee\Utils\MemberNames;
use TechDivision\Import\Observers\AttributeObserverTrait;

/**
 * Trait that provides basic EAV attribute functionality for Magento EE.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-ee
 * @link      http://www.techdivision.com
 */
trait EeAttributeObserverTrait
{

    /**
     * The attribute observer trait implementation.
     *
     * @var \TechDivision\Import\Observers\AttributeObserverTrait
     */
    use AttributeObserverTrait;

    /**
     * Return's the PK column name to create the product => attribute relation.
     *
     * @return string The PK column name
     */
    protected function getPrimaryKeyMemberName()
    {
        return MemberNames::ROW_ID;
    }

    /**
     * Return's the PK to create the product => attribute relation.
     *
     * @return integer The PK to create the relation with
     */
    protected function getPrimaryKey()
    {
        return $this->getLastRowId();
    }

    /**
     * Return's the row ID of the product that has been created recently.
     *
     * @return string The row Id
     */
    protected function getLastRowId()
    {
        return $this->getSubject()->getLastRowId();
    }
}
