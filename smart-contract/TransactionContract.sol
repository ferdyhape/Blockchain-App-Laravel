//SPDX-License-Identifier: MIT

pragma solidity 0.8.16;

contract TransactionContract {
    struct Transaction {
        uint transactionId;
        string transactionCode;
        string buyer;
        string buyerId;
        string sellerCompany;
        string sellerId;
        uint sumOfProduct;
        string totalPrice;
        string paymentStatus;
        uint createdAt;
    }

    struct TransactionDetails {
        string transactionCode;
        string productName;
        string productDescription;
        string tokenOfProduct;
        string price;
        uint createdAt;
    }

    mapping(uint => Transaction) public transactions;
    mapping(uint => TransactionDetails) public transactionDetails;
    uint public transactionCount;
    uint public transactionDetailsCount;

    // if transacttion created, add transaction details with data using array
    function createTransaction(
        string memory _transactionCode,
        string memory _buyer,
        string memory _buyerId,
        string memory _sellerCompany,
        string memory _sellerId,
        uint _sumOfProduct,
        string memory _totalPrice,
        string memory _paymentStatus,
        uint _createdAt,
        string[] memory _productNames,
        string[] memory _productDescriptions,
        string[] memory _tokenOfProducts,
        string[] memory _prices
    ) public {
        transactionCount++;
        transactions[transactionCount] = Transaction(
            transactionCount,
            _transactionCode,
            _buyer,
            _buyerId,
            _sellerCompany,
            _sellerId,
            _sumOfProduct,
            _totalPrice,
            _paymentStatus,
            _createdAt
        );

        for (uint i = 0; i < _productNames.length; i++) {
            transactionDetailsCount++;
            transactionDetails[transactionDetailsCount] = TransactionDetails(
                _transactionCode,
                _productNames[i],
                _productDescriptions[i],
                _tokenOfProducts[i],
                _prices[i],
                _createdAt
            );
        }
    }

    function getTransaction(
        uint _transactionId
    ) public view returns (Transaction memory) {
        return transactions[_transactionId];
    }

    function updatePaymentStatus(
        uint _transactionId,
        string memory _paymentStatus,
        uint _createdAt
    ) public {
        Transaction memory originalTransaction = transactions[_transactionId];
        transactionCount++;
        transactions[transactionCount] = Transaction(
            transactionCount,
            originalTransaction.transactionCode,
            originalTransaction.buyer,
            originalTransaction.buyerId,
            originalTransaction.sellerCompany,
            originalTransaction.sellerId,
            originalTransaction.sumOfProduct,
            originalTransaction.totalPrice,
            _paymentStatus,
            _createdAt
        );
    }

    function getAllTransaction() public view returns (Transaction[] memory) {
        Transaction[] memory _transactions = new Transaction[](
            transactionCount
        );
        for (uint i = 1; i <= transactionCount; i++) {
            _transactions[i - 1] = transactions[i];
        }
        return _transactions;
    }

    function getTransactionByBuyerId(
        string memory _buyerId
    ) public view returns (Transaction[] memory) {
        uint count = 0;
        for (uint i = 1; i <= transactionCount; i++) {
            if (
                keccak256(abi.encodePacked(transactions[i].buyerId)) ==
                keccak256(abi.encodePacked(_buyerId))
            ) {
                count++;
            }
        }
        Transaction[] memory _transactions = new Transaction[](count);
        uint j = 0;
        for (uint i = 1; i <= transactionCount; i++) {
            if (
                keccak256(abi.encodePacked(transactions[i].buyerId)) ==
                keccak256(abi.encodePacked(_buyerId))
            ) {
                _transactions[j] = transactions[i];
                j++;
            }
        }
        return _transactions;
    }

    function getTransactionBySellerId(
        string memory _sellerId
    ) public view returns (Transaction[] memory) {
        uint count = 0;
        for (uint i = 1; i <= transactionCount; i++) {
            if (
                keccak256(abi.encodePacked(transactions[i].sellerId)) ==
                keccak256(abi.encodePacked(_sellerId))
            ) {
                count++;
            }
        }
        Transaction[] memory _transactions = new Transaction[](count);
        uint j = 0;
        for (uint i = 1; i <= transactionCount; i++) {
            if (
                keccak256(abi.encodePacked(transactions[i].sellerId)) ==
                keccak256(abi.encodePacked(_sellerId))
            ) {
                _transactions[j] = transactions[i];
                j++;
            }
        }
        return _transactions;
    }
}
