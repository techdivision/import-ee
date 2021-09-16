<?php

/**
 * TechDivision\Import\Ee\Utils\SqlConstants
 *
 * PHP version 7
 *
 * @author    David Führ <d.fuehr@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Ee\Utils;

/**
 * Utility class with SQL constants.
 *
 * @author    David Führ <d.fuehr@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */
class SqlConstants
{

    /**
     * SQL constant defining the maximum supported unix timestamp. Represents 2038-01-19 03:14:07.
     *
     * @see \Magento\Staging\Model\VersionManager::MAX_VERSION
     *
     * @var string
     */
    const MAX_UNIXTIMESTAMP = 2147483647;
}
