<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Talk;

class Department extends BaseClient
{
    /**
     * 获取子部门 ID 列表
     *
     * @param string $id 部门ID
     *
     * @return mixed
     */
    public function getSubDepartmentIds(string $id): array
    {
        return $this->client->get('department/list_ids', ['query' => compact('id')])->jsonArray();
    }

    /**
     * 获取部门列表
     *
     * @param bool   $isFetchChild
     * @param string $id
     * @param string $lang
     *
     * @return mixed
     */
    public function list(string $id = null, bool $isFetchChild = false, string $lang = null): array
    {
        return $this->client->get('department/list', ['query' => [
            'id' => $id, 'lang' => $lang, 'fetch_child' => $isFetchChild ? 'true' : 'false',
        ]])->jsonArray();
    }

    /**
     * 获取部门详情
     *
     * @param string $id
     * @param string $lang
     *
     * @return mixed
     */
    public function get(string $id, string $lang = null): array
    {
        return $this->client->get('department/get', ['query' => compact('id', 'lang')])->jsonArray();
    }

    /**
     * 查询部门的所有上级父部门路径
     *
     * @param string $id
     *
     * @return mixed
     */
    public function getParentsById(string $id): array
    {
        return $this->client->get('department/list_parent_depts_by_dept', ['query' => compact('id')])->jsonArray();
    }

    /**
     * 查询指定用户的所有上级父部门路径
     *
     * @param string $userId
     *
     * @return mixed
     */
    public function getParentsByUserId(string $userId): array
    {
        return $this->client->get('department/list_parent_depts', ['query' => compact('userId')])->jsonArray();
    }

    /**
     * 创建部门
     *
     * @param array $params
     *
     * @return mixed
     */
    public function create(array $params): array
    {
        return $this->client->postJson('department/create', ['query' => $params])->jsonArray();
    }

    /**
     * 更新部门
     *
     * @param string $id
     * @param array  $params
     *
     * @return mixed
     */
    public function update(string $id, array $params): array
    {
        return $this->client->post('department/update', ['query' => compact('id') + $params])->jsonArray();
    }

    /**
     * 删除部门
     *
     * @param string $id
     *
     * @return mixed
     */
    public function delete(string $id): array
    {
        return $this->client->get('department/delete', ['query' => compact('id')])->jsonArray();
    }
}
