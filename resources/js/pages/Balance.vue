<script>

export default {
    name: "Balance"
}
</script>

<template>
    <div class="p-1" style="">
        <div class="card ">
            <div class="flex justify-between align-items-center">
                <div><h1 class="">Баланс</h1></div>
                <div><h1>3000</h1></div>
            </div>
        </div>

        <div class="card ">
            <div class="flex justify-between align-items-center">
                <div><h1 class="">Пополнений</h1></div>
                <div><h1>3</h1></div>
            </div>
        </div>

        <div class="card ">
            <div class="flex justify-between align-items-center">
                <div><h1 class="">Списаний</h1></div>
                <div><h1>6</h1></div>
            </div>
        </div>

        <div class="card">
            <div class="flex justify-between items-center mb-6">
                <div class=""><h1>Последние операции</h1></div>
            </div>
            <ul class="list-none">
                <li class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h5 class="">Пополнение</h5>
                        <small class="text-gray-300">2024-10-01 23:53:59</small>
                    </div>
                    <div class="flex items-center"><h2 style="color: green">+500₽</h2></div>
                </li>
                <li class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h5 class="">Списание</h5>
                        <small class="text-gray-300">2024-10-01 23:53:59</small>
                    </div>
                    <div class="flex items-center"><h2 style="color: red">-500₽</h2></div>
                </li>
                <li class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h5 class="">Пополнение</h5>
                        <small class="text-gray-300">2024-10-01 23:53:59</small>
                    </div>
                    <div class="flex items-center"><h2 style="color: green">+500₽</h2></div>
                </li>
                <li class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h5 class="">Пополнение</h5>
                        <small class="text-gray-300">2024-10-01 23:53:59</small>
                    </div>
                    <div class="flex items-center"><h2 style="color: green">+500₽</h2></div>
                </li>
                <li class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h5 class="">Списание</h5>
                        <small class="text-gray-300">2024-10-01 23:53:59</small>
                    </div>
                    <div class="flex items-center"><h2 style="color: red">-10000₽</h2></div>
                </li>
                <li class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h5 class="">Пополнение</h5>
                        <small class="text-gray-300">2024-10-01 23:53:59</small>
                    </div>
                    <div class="flex items-center"><h2 style="color: green">+500₽</h2></div>
                </li>
            </ul>
        </div>

    </div>

</template>

<style>
.balance-row {
    display: flex;
    justify-content: center;
    align-items: center;
    justify-items: center;
}

.balance-card {
    display: flex;
    padding: 2rem;
}
</style>
