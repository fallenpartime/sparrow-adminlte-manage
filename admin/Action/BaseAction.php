<?php
/**
 * 基础action
 * Date: 2018/11/30
 * Time: 15:43
 */
namespace Admin\Action;

use Frameworks\Tool\Http\HttpTool;
use Illuminate\Http\Request;

class BaseAction
{
    protected $request = null;
    protected $httpTool = null;
    protected $authService = null;
    protected $logService = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getHttpTool()
    {
        if (empty($this->httpTool)) {
            $this->httpTool = new HttpTool($this->request);
        }
        return $this->httpTool;
    }
}