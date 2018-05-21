<div id="prizeActions" class="text-center d-none">

    <h4 class="text-success">Congratulation, you won <span id="prize"></span> !</h4>
    <div id="moneyAction" class="prize-actions d-none">
        <a class="link-action" data-handler="onTransferToBank" href="/prizes/tobank/">Transfer Money To Bank Account</a><br>
        <a class="link-action" data-handler="onHandlePrize" href="/prizes/moneytopoints/">Transfer Money To
            Points</a><br>
    </div>
    <div id="pointsAction" class="prize-actions d-none">
        <a class="link-action" data-handler="onHandlePrize" href="/prizes/toaccount/">Put Points To My Account</a><br>
    </div>
    <div id="goodsAction" class="prize-actions d-none">
        <a class="link-action" data-handler="onHandlePrize" href="/prizes/delivery/">Delivery The Prize To My Adress</a><br>
    </div>
    <a id="refusalAction" data-handler="onHandlePrize" class="link-action" href="/prizes/refusal/">Refusal Of This
        Prize</a><br>

</div>