<?php

namespace FondOfOryx\Zed\CreditMemoPayoneDebitConnector;

use FondOfOryx\Zed\CreditMemoPayoneDebitConnector\Dependency\Facade\CreditMemoPayoneDebitConnectorToCreditMemoBridge;
use FondOfOryx\Zed\CreditMemoPayoneDebitConnector\Dependency\Facade\CreditMemoPayoneDebitConnectorToSalesFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CreditMemoPayoneDebitConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_SALES = 'FACADE_SALES';

    /**
     * @var string
     */
    public const FACADE_CREDIT_MEMO = 'FACADE_CREDIT_MEMO';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addSalesFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesFacade(Container $container): Container
    {
        $container[static::FACADE_SALES] = static function (Container $container) {
            return new CreditMemoPayoneDebitConnectorToSalesFacadeBridge(
                $container->getLocator()->sales()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addCreditMemoFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCreditMemoFacade(Container $container): Container
    {
        $container[static::FACADE_CREDIT_MEMO] = static function (Container $container) {
            return new CreditMemoPayoneDebitConnectorToCreditMemoBridge(
                $container->getLocator()->creditMemo()->facade(),
            );
        };

        return $container;
    }
}
