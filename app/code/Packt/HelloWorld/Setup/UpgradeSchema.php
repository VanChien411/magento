<?php

namespace Packt\HelloWorld\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.3', '<')) {
            $installer = $setup;
            $installer->startSetup();

            if (!$installer->tableExists('packt_helloworld_subscription')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('packt_helloworld_subscription')
                )->addColumn(
                    'subscription_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Subscription ID'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )->addColumn(
                    'firstname',
                    Table::TYPE_TEXT,
                    64,
                    ['nullable' => false],
                    'First Name'
                )->addColumn(
                    'lastname',
                    Table::TYPE_TEXT,
                    64,
                    ['nullable' => false],
                    'Last Name'
                )->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Email Address'
                )->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => 'pending'],
                    'Status'
                )->addColumn(
                    'message',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'Subscription Notes'
                )->addIndex(
                    $installer->getIdxName('packt_helloworld_subscription', ['email']),
                    ['email']
                )->setComment('Packt HelloWorld Subscription');

                $installer->getConnection()->createTable($table);
            }

            $installer->endSetup();
        }
    }
}
