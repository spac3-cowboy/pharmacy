import {useEffect, useState} from "react";
import axios from "axios";
import Left from "./Left.jsx";
import Right from "./Right.jsx";

export default function POS() {
    const [customers, setCustomers] = useState([9,9,9,9]);
    const [categories, setCategories] = useState([]);
    const [vendors, setVendors] = useState([]);
    const [stocks, setStocks] = useState([]);
    const [carts, setCarts] = useState([]);
    const [vat, setVat] = useState(0);


    const renderPage = async () => {
        TurnOverlayOn();
        let r = await axios.get("/dashboard/pos/get-page-data")
            .then(response => {
                setCustomers(response.data.customers);
                setStocks(response.data.stocks);
                setCategories(response.data.categories);
                setVendors(response.data.vendors);
                setCarts(response.data.carts);
                setVat(response.data.vat);
                console.log(response.data.vat)
            });
        TurnOverlayOff();
        return r;
    }
    // @ts-ignore
    useEffect(()=>{
        renderPage();
    },[])



    return (
        <>
            <Left setCarts={setCarts} stocks={stocks} categories={categories} vendors={vendors} />
            <Right setStocks={setStocks} setCarts={setCarts} carts={carts} vat={vat} customers={customers} />
        </>
    )
}

