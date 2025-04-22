<?php
namespace Packt\HelloWorld\Block\Html;

class Calendar extends \Magento\Framework\View\Element\Html\Calendar
{
    protected function _toHtml()
    {
        $localeData = $this->getData('localeData');
        $logger = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Psr\Log\LoggerInterface::class);

        // Xác nhận lớp override được gọi
        $logger->debug('Custom Calendar Block Loaded for locale: ' . $this->_localeResolver->getLocale());

        // Xử lý AM/PM
        if ($localeData instanceof \ResourceBundle && isset($localeData['calendar']['gregorian']['AmPmMarkers'])) {
            $this->assign('am', $this->encoder->encode($localeData['calendar']['gregorian']['AmPmMarkers']['0']));
            $this->assign('pm', $this->encoder->encode($localeData['calendar']['gregorian']['AmPmMarkers']['1']));
        } else {
            $this->assign('am', 'AM');
            $this->assign('pm', 'PM');
            $logger->debug('Locale Data is empty or invalid for AmPmMarkers: ' . $this->_localeResolver->getLocale());
        }

        // Xử lý dayNames
        if ($localeData instanceof \ResourceBundle && isset($localeData['calendar']['gregorian']['dayNames']['format']['abbreviated'])) {
            $this->assign('days', $this->encoder->encode($localeData['calendar']['gregorian']['dayNames']['format']['abbreviated']));
        } else {
            $this->assign('days', ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']);
            $logger->debug('Locale Data is empty or invalid for dayNames: ' . $this->_localeResolver->getLocale());
        }

        // Xử lý monthNames
        if ($localeData instanceof \ResourceBundle && isset($localeData['calendar']['gregorian']['monthNames']['format']['abbreviated'])) {
            $this->assign('months', $this->encoder->encode($localeData['calendar']['gregorian']['monthNames']['format']['abbreviated']));
        } else {
            $this->assign('months', ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
            $logger->debug('Locale Data is empty or invalid for monthNames: ' . $this->_localeResolver->getLocale());
        }

        // Debug trước khi gọi parent::_toHtml
        $logger->debug('Calling parent::_toHtml for locale: ' . $this->_localeResolver->getLocale());

        return parent::_toHtml();
    }
}