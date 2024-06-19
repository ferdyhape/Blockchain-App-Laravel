//SPDX-License-Identifier: MIT
pragma solidity 0.8.16;

contract TransactionContract {
    struct Transaction {
        string transactionCode;
        uint campaignId;
        uint fromToUserId;
        string orderType;
        string paymentStatus;
        string status;
        uint quantity;
        uint256 totalPrice;
        uint createdAt;
    }

    mapping(string => Transaction) public transactions; // Deklarasi mapping
    string[] public transactionCodes; // Array untuk menyimpan kode transaksi

    event TransactionAdded(
        string transactionCode,
        uint campaignId,
        uint fromToUserId,
        string orderType,
        string paymentStatus,
        string status,
        uint quantity,
        uint256 totalPrice,
        uint createdAt
    );

    event StatusUpdated(string transactionCode, string newStatus);

    event PaymentStatusUpdated(string transactionCode, string newPaymentStatus);

    constructor() {
        // Buat konstruktor
    }

    function addTransaction(
        string memory _transactionCode,
        uint _campaignId,
        uint _fromToUserId,
        string memory _orderType,
        string memory _paymentStatus,
        string memory _status,
        uint _quantity,
        uint256 _totalPrice,
        uint _createdAt
    ) public {
        transactions[_transactionCode] = Transaction(
            _transactionCode,
            _campaignId,
            _fromToUserId,
            _orderType,
            _paymentStatus,
            _status,
            _quantity,
            _totalPrice,
            _createdAt
        );

        transactionCodes.push(_transactionCode); // Tambahkan kode transaksi ke dalam array

        emit TransactionAdded(
            _transactionCode,
            _campaignId,
            _fromToUserId,
            _orderType,
            _paymentStatus,
            _status,
            _quantity,
            _totalPrice,
            _createdAt
        );
    }

    function getAllTransactions() public view returns (Transaction[] memory) {
        Transaction[] memory allTransactions = new Transaction[](
            transactionCodes.length
        );
        for (uint i = 0; i < transactionCodes.length; i++) {
            allTransactions[i] = transactions[transactionCodes[i]];
        }
        return allTransactions;
    }

    function updateStatus(
        string memory _transactionCode,
        string memory _newStatus
    ) public {
        require(
            bytes(transactions[_transactionCode].transactionCode).length != 0,
            "Transaction does not exist"
        );
        transactions[_transactionCode].status = _newStatus;
        emit StatusUpdated(_transactionCode, _newStatus);
    }

    function updatePaymentStatus(
        string memory _transactionCode,
        string memory _newPaymentStatus
    ) public {
        require(
            bytes(transactions[_transactionCode].transactionCode).length != 0,
            "Transaction does not exist"
        );
        transactions[_transactionCode].paymentStatus = _newPaymentStatus;
        emit PaymentStatusUpdated(_transactionCode, _newPaymentStatus);
    }

    function getTransactionByFromToUserId(
        uint _fromToUserId
    ) public view returns (Transaction[] memory) {
        uint count = 0;
        for (uint i = 0; i < transactionCodes.length; i++) {
            if (
                transactions[transactionCodes[i]].fromToUserId == _fromToUserId
            ) {
                count++;
            }
        }
        Transaction[] memory result = new Transaction[](count);
        uint index = 0;
        for (uint i = 0; i < transactionCodes.length; i++) {
            if (
                transactions[transactionCodes[i]].fromToUserId == _fromToUserId
            ) {
                result[index] = transactions[transactionCodes[i]];
                index++;
            }
        }
        return result;
    }

    function getTransactionByCode(
        string memory _transactionCode
    ) public view returns (Transaction memory) {
        require(
            bytes(transactions[_transactionCode].transactionCode).length != 0,
            "Transaction does not exist"
        );
        return transactions[_transactionCode];
    }

    function getTransactionByCampaignId(
        uint _campaignId
    ) public view returns (Transaction[] memory) {
        uint count = 0;
        for (uint i = 0; i < transactionCodes.length; i++) {
            if (transactions[transactionCodes[i]].campaignId == _campaignId) {
                count++;
            }
        }
        Transaction[] memory result = new Transaction[](count);
        uint index = 0;
        for (uint i = 0; i < transactionCodes.length; i++) {
            if (transactions[transactionCodes[i]].campaignId == _campaignId) {
                result[index] = transactions[transactionCodes[i]];
                index++;
            }
        }
        return result;
    }
}
