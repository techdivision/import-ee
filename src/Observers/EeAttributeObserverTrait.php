<?php

/**
 * TechDivision\Import\Product\Ee\Observers\EeProductAttributeObserverTrait
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Ee\Observers;

use TechDivision\Import\Utils\MemberNames;
use TechDivision\Import\Utils\StoreViewCodes;
use TechDivision\Import\Observers\AttributeObserverTrait;

/**
 * Trait that provides basic EAV attribute functionality for Magento EE.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // load the callbacks for the actual attribute code
        $callbacks = $this->getCallbacksByType($this->attributeCode);

        // invoke the pre-cast callbacks
        foreach ($callbacks as $callback) {
            $this->attributeValue = $callback->handle($this->attributeCode, $this->attributeValue);
        }

        // query whether or not the attribute has been be processed by the callbacks
        if ($this->attributeValue === null) {
            return;
        }

        // load the ID of the product that has been created recently
        $lastEntityId = $this->getPrimaryKey();

        // load the store ID
        $storeId = $this->getRowStoreId(StoreViewCodes::ADMIN);

        // cast the value based on the backend type
        $castedValue = $this->castValueByBackendType($this->backendType, $this->attributeValue);

        // prepare the attribute values
        return $this->initializeEntity(
            array(
                MemberNames::ROW_ID       => $lastEntityId,
                MemberNames::ATTRIBUTE_ID => $this->attributeId,
                MemberNames::STORE_ID     => $storeId,
                MemberNames::VALUE        => $castedValue
            )
        );
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
