<?php

/**
 * Class Validator
 */
class Validator
{
    private $errorMsg = array(); //存储错误信息
    /**
     * 验证器的规则及对应的方法
     * 格式:
     * '规则名称' => '验证方法名'
     *
     * @var array
     */
    private $validateRuler = array(
        'required' => 'checkExists',
    );

    /**
     * 验证字段是否为空
     *
     * @param $param
     *
     * @return bool
     */
    private function checkExists($param)
    {
        if ($param == '') return FALSE;

        return TRUE;
    }

    /**
     * @param       $params
     * @param array $rules
     * @param array $messages
     *
     * @throws Exception
     */
    public function make($params, array $rules, array $messages)
    {

        foreach ($rules as $field => $rule) {
            $param = $params[$field];
            $this->AnalyticalRule($field, $param, $rule, $messages);
        }
    }

    /**
     * @return bool
     */
    public function fails()
    {
        if (count($this->errorMsg) < 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @return array
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * 解析规则
     *
     * @param $field
     * @param $param
     * @param $rule
     * @param $messages
     *
     * @throws Exception
     */
    private function AnalyticalRule($field, $param, $rule, $messages)
    {
        if (strstr($rule, '|')) {
            $ruleArr = explode('|', $rule);
            foreach ($ruleArr as $k => $v_rule) {
                if (!array_key_exists($v_rule, $this->validateRuler))
                    throw new Exception($v_rule . '验证规则不存在', Constants_ErrorCodeEnum::STATUS_ERROR);
                $method = $this->validateRuler[$rule];
                if (!$this->$method($param)) {
                    $msgKey = $field . '.' . $v_rule;
                    array_push($this->errorMsg, $messages[$msgKey]);
                }
            }
        } else {
            if (!array_key_exists($rule, $this->validateRuler)) {
                throw new Exception($rule . '验证规则不存在', Constants_ErrorCodeEnum::STATUS_ERROR);
            }
            $method = $this->validateRuler[$rule];
            if (!$this->$method($param)) {
                $msgKey = $field . '.' . $rule;
                array_push($this->errorMsg, $messages[$msgKey]);
            }
        }
    }
} 