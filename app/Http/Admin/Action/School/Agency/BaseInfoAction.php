<?php
/**
 * 基础内容处理
 * Date: 2018/12/10
 * Time: 22:21
 */
namespace App\Http\Admin\Action\School\Agency;

use Admin\Action\BaseAction;
use Admin\Services\School\Agency\Processor\AgencyPictureProcessor;

class BaseInfoAction extends BaseAction
{
    protected $record = null;
    protected $pictureProcessor = null;

    protected function getPictureProcessor()
    {
        if (empty($this->pictureProcessor)) {
            $this->pictureProcessor = new AgencyPictureProcessor();
        }
        return $this->pictureProcessor;
    }

    protected function clearImage($agencyId)
    {
        if ($agencyId > 0) {
            $this->getPictureProcessor()->remove(['agency_id'=>$agencyId, 'type'=>1]);
        }
    }

    protected function processCreateImage($imageUrl, $agencyId)
    {
        $imageUrl = trim($imageUrl);
        if ($agencyId <= 0) {
            return false;
        }
        if (!empty($imageUrl)) {
            $data = [
                'agency_id'     =>  $agencyId,
                'type'          =>  1,
                'pic'           =>  $imageUrl,
            ];
        }
        $this->clearImage($agencyId);
        if (!empty($data)) {
            list($status, $picture) = $this->getPictureProcessor()->insert($data);
            return $status;
        }
        return false;
    }

    protected function processEditImage($imageUrl, $agencyId)
    {
        $imageUrl = trim($imageUrl);
        if ($agencyId <= 0) {
            return false;
        }
        if (!empty($imageUrl)) {
            $data = [
                'agency_id'     =>  $agencyId,
                'type'          =>  1,
                'pic'           =>  $imageUrl,
            ];
        }
        if (empty($imageUrl)) {
            $this->clearImage($agencyId);
        } else if($imageUrl != $this->record->list_pic) {
            $this->clearImage($agencyId);
            if (!empty($data)) {
                list($status, $picture) = $this->getPictureProcessor()->insert($data);
                return $status;
            }
        }
        return false;
    }
}