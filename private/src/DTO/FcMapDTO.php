<?php

namespace App\DTO;

class FcMapDTO {
    private ?int $id;
    private ?string $menuType;
    private int $menuId;
    private ?string $menuName;
    private int $commId;
    private ?string $commName;
    private float $amount;
    private ?string $uom;
    private ?float $costPerUom;
    private ?float $costExtend;

    public function __construct(
        ?int $id,
        ?string $menuType,
        int $menuId,
        ?string $menuName,
        int $commId,
        ?string $commName,
        float $amount,
        ?string $uom,
        ?float $costPerUom,
        ?float $costExtend
    ) {
        $this->id = $id;
        $this->menuType = $menuType;
        $this->menuId = $menuId;
        $this->menuName = $menuName;
        $this->commId = $commId;
        $this->commName = $commName;
        $this->amount = $amount;
        $this->uom = $uom;
        $this->costPerUom = $costPerUom;
        $this->costExtend = $costExtend;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getMenuType(): ?string {
        return $this->menuType;
    }

    public function getMenuId(): int {
        return $this->menuId;
    }

    public function getMenuName(): ?string {
        return $this->menuName;
    }

    public function getCommId(): int {
        return $this->commId;
    }

    public function getCommName(): ?string {
        return $this->commName;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getUom(): ?string {
        return $this->uom;
    }

    public function getCostPerUom(): ?float {
        return $this->costPerUom;
    }

    public function getCostExtend(): ?float {
        return $this->costExtend;
    }

    // Setters
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setMenuType(?string $menuType): void {
        $this->menuType = $menuType;
    }

    public function setMenuId(int $menuId): void {
        $this->menuId = $menuId;
    }

    public function setMenuName(?string $menuName): void {
        $this->menuName = $menuName;
    }

    public function setCommId(int $commId): void {
        $this->commId = $commId;
    }

    public function setCommName(?string $commName): void {
        $this->commName = $commName;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function setUom(?string $uom): void {
        $this->uom = $uom;
    }

    public function setCostPerUom(?float $costPerUom): void {
        $this->costPerUom = $costPerUom;
    }

    public function setCostExtend(?float $costExtend): void {
        $this->costExtend = $costExtend;
    }
}
