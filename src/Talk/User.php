<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Talk;

class User extends BaseClient
{
    /**
     * 获取用户详情
     *
     * @param string $userid
     * @param string|null $lang
     *
     * @return mixed
     */
    public function get(string $userid, string $lang = null): array
    {
        return $this->client->get('user/get', ['query' => compact('userid', 'lang')])->jsonArray();
    }

    /**
     * 获取部门用户 Userid 列表
     *
     * @param int $departmentId
     *
     * @return mixed
     */
    public function getUserIds(int $departmentId): array
    {
        return $this->client->get('user/getDeptMember', ['query' => ['deptId' => $departmentId]])->jsonArray();
    }

    /**
     * 获取部门用户
     *
     * @param int $departmentId
     * @param int $offset
     * @param int $size
     * @param string $order
     * @param string $lang
     *
     * @return mixed
     */
    public function getUsers(int $departmentId, int $offset, int $size, string $order = null, string $lang = null): array
    {
        return $this->client->get('user/simplelist', ['query' => [
            'department_id' => $departmentId, 'offset' => $offset, 'size' => $size, 'order' => $order, 'lang' => $lang,
        ]])->jsonArray();
    }

    /**
     * 获取部门用户详情
     *
     * @param int $departmentId
     * @param int $offset
     * @param int $size
     * @param string $order
     * @param string $lang
     *
     * @return mixed
     */
    public function getDetailedUsers(int $departmentId, int $offset, int $size, string $order = null, string $lang = null): array
    {
        return $this->client->get('user/listbypage', ['query' => [
            'department_id' => $departmentId, 'offset' => $offset, 'size' => $size, 'order' => $order, 'lang' => $lang,
        ]])->jsonArray();
    }

    /**
     * 获取管理员列表
     *
     * @return mixed
     */
    public function administrators(): array
    {
        return $this->client->get('user/get_admin')->jsonArray();
    }

    /**
     * 获取管理员通讯录权限范围
     *
     * @param string $userid
     *
     * @return mixed
     */
    public function administratorScope(string $userid): array
    {
        return $this->client->get('topapi/user/get_admin_scope', ['query' => compact('userid')])->jsonArray();
    }

    /**
     * 根据 Unionid 获取 Userid
     *
     * @param string $unionid
     *
     * @return mixed
     */
    public function getUseridByUnionid(string $unionid): array
    {
        return $this->client->get('user/getUseridByUnionid', ['query' => compact('unionid')])->jsonArray();
    }

    /**
     * 创建用户
     *
     * @param array $params
     *
     * @return mixed
     */
    public function create(array $params): array
    {
        return $this->client->post('user/create', ['query' => $params])->jsonArray();
    }

    /**
     * 更新用户
     *
     * @param string $userid
     * @param array $params
     *
     * @return mixed
     */
    public function update(string $userid, array $params)
    {
        return $this->client->post('user/update', ['query' => compact('userid') + $params])->jsonArray();
    }

    /**
     * 删除用户
     *
     * @param $userid
     *
     * @return mixed
     */
    public function delete(string $userid)
    {
        return $this->client->get('user/delete', ['query' => compact('userid')])->jsonArray();
    }

    /**
     * 企业内部应用免登获取用户 Userid
     *
     * @param string $code
     *
     * @return mixed
     */
    public function getUserByCode(string $code)
    {
        return $this->client->get('user/getuserinfo', ['query' => compact('code')])->jsonArray();
    }

    /**
     * 批量增加员工角色
     *
     * @param array $userIds
     * @param array $roleIds
     *
     * @return mixed
     */
    public function addRoles(array $userIds, array $roleIds)
    {
        $userIds =  implode(',', $userIds);
        $roleIds = implode(',', $roleIds);

        return $this->client->post('topapi/role/addrolesforemps', ['query' => compact('userIds', 'roleIds')])->jsonArray();
    }

    /**
     * 批量删除员工角色
     *
     * @param array $userIds
     * @param array $roleIds
     *
     * @return mixed
     */
    public function removeRoles(array $userIds, array $roleIds)
    {
        $userIds = implode(',', $userIds);
        $roleIds = implode(',', $roleIds);

        return $this->client->post('topapi/role/removerolesforemps', ['query' => compact('userIds', 'roleIds')])->jsonArray();
    }

    /**
     * 获取企业员工人数
     *
     * @param int $onlyActive
     *
     * @return mixed
     */
    public function getCount(int $onlyActive = 0)
    {
        return $this->client->get('user/get_org_user_count', ['query' => compact('onlyActive')]);
    }

    /**
     * 获取企业已激活的员工人数
     *
     * @return mixed
     */
    public function getActivatedCount()
    {
        return $this->getCount(1);
    }

    /**
     * 根据员工手机号获取 Userid
     *
     * @param string $mobile
     *
     * @return mixed
     */
    public function getUserIdByPhone(string $mobile = '')
    {
        return $this->client->get('user/get_by_mobile', ['query' => compact('mobile')])->jsonArray();
    }

    /**
     * 未登录钉钉的员工列表
     *
     * @param string $query_date
     * @param int $offset
     * @param int $size
     *
     * @return mixed
     */
    public function getInactiveUsers(string $query_date, int $offset, int $size)
    {
        return $this->client->post('topapi/inactive/user/get', ['query' => [
            'query_date' => $query_date, 'offset' => $offset, 'size' => $size
        ]]);
    }
}
