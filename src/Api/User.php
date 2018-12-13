<?php
/**
 * User: salamander
 * Date: 18-12-12
 * Time: 上午11:12
 */

namespace YunXinHelper\Api;


class User extends Base
{
    const GET_UINFOS_LIMIT = 200;

    /**
     * 创建网易云通信ID
     * @param string $accid
     * @param string $name
     * @param string $icon
     * @param string $token
     * @param string $sign
     * @param string $email
     * @param string $birth
     * @param string $mobile
     * @param int $gender
     * @param string $ex
     * @param array $props
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function create($accid, $name, $icon, $token, $sign, $email, $birth, $mobile, $gender, $ex, array $props = []) {
        if (!$accid || !is_string($accid)) {
            throw new \LogicException('accid 不合法！');
        }
        $res = $this->sendRequest('/user/create.action', [
            'accid' => $accid,
            'name' => $name,
            'icon' => $icon,
            'token' => $token,
            'sign' => $sign,
            'email' => $email,
            'birth' => $birth,
            'mobile' => $mobile,
            'gender' => $gender,
            'ex' => $ex,
            'props' => json_encode($props),
        ]);
        return $res['info'];
    }


    /**
     * 网易云通信ID基本信息更新
     * @param $accid
     * @param $token
     * @param array $props
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function update($accid, $token, array $props = []) {
        if (!$accid || !is_string($accid)) {
            throw new \LogicException('accid 不合法！');
        }
        $res = $this->sendRequest('/user/update.action', [
            'accid' => $accid,
            'token' => $token,
            'props' => json_encode($props),
        ]);
        return $res;
    }

    /**
     * 更新并获取新token
     * @param $accid
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function refreshToken($accid) {
        if (!$accid || !is_string($accid)) {
            throw new \LogicException('accid 不合法！');
        }
        $res = $this->sendRequest('/user/refreshToken.action', [
            'accid' => $accid,
        ]);
        return $res['info'];
    }


    /**
     * 封禁网易云通信ID
     * @param $accid
     * @param bool $kick 是否踢掉被禁用户，true或false，默认false
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function block($accid, $kick) {
        if (!$accid || !is_string($accid)) {
            throw new \LogicException('accid 不合法！');
        }
        $res = $this->sendRequest('/user/block.action', [
            'accid' => $accid,
            'needkick' => $kick,
        ]);
        return $res;
    }

    /**
     * 解禁网易云通信ID
     * @param $accid
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function unblock($accid) {
        if (!$accid || !is_string($accid)) {
            throw new \LogicException('accid 不合法！');
        }
        $res = $this->sendRequest('/user/unblock.action', [
            'accid' => $accid,
        ]);
        return $res;
    }


    /**
     * 更新用户名片
     * @param $accid
     * @param $name
     * @param $icon
     * @param $sign
     * @param $email
     * @param $birth
     * @param $mobile
     * @param $gender
     * @param $ex
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function updateUserInfo($accid, $name, $icon, $sign, $email, $birth, $mobile, $gender, $ex) {
        if (!$accid || !is_string($accid)) {
            throw new \LogicException('accid 不合法！');
        }
        $res = $this->sendRequest('/user/updateUinfo.action', [
            'accid' => $accid,
            'name' => $name,
            'icon' => $icon,
            'sign' => $sign,
            'email' => $email,
            'birth' => $birth,
            'mobile' => $mobile,
            'gender' => $gender,
            'ex' => $ex,
        ]);
        return $res;
    }

    /**
     * 获取用户名片，可以批量
     * @param array $accids
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \YunXinHelper\Excetption\YunXinBusinessException
     * @throws \YunXinHelper\Excetption\YunXinNetworkException
     */
    public function getUserInfos(array $accids) {
        if (empty($accids)) {
            throw new \LogicException('查询用户不能为空！');
        }
        if (count($accids) > self::GET_UINFOS_LIMIT) {
            throw new \LogicException('查询用户数量超过限制！');
        }
        $res = $this->sendRequest('/user/updateUinfo.action', [
            'accids' => json_encode($accids)
        ]);
        return $res['uinfos'];
    }
}