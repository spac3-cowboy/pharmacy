import {useEffect, useRef, useState} from "react";
import axios from "axios";
import Select from 'react-select'
import Swal from "sweetalert2";

function Left(props) {
    let [categories, setCategories] = useState([]);
    let [vendors, setVendors] = useState([]);
    let [stocks, setStocks] = useState([]);

    let { setCarts } = props;
    let catFilter = useRef();
    let keyFilter = useRef();

    useEffect(()=>{
        setCategories(props.categories);
        setVendors(props.vendors);
        setStocks(props.stocks);
    },[props]);

    const addToCart = (medicine_id) => {
        TurnOverlayOn();
        axios.post("/dashboard/pos/add-to-cart",{
            _token: document.querySelector('meta[name="csrf-token"]').content,
            medicine_id: medicine_id
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                setCarts(response.data.carts);
            } else {
                Swal.fire({
                    "title" : "Failed",
                    text: response.data.error,
                    icon: 'error',
                    confirmButtonText: 'ok'
                });
            }
            TurnOverlayOff();
        })
        .catch(err=>{
            console.log(err)
            TurnOverlayOff();
        })
    }
    const search = () => {
        let key = keyFilter.current.value;
        let cat_id = catFilter.current.value;
        let qparam = `?`;
        if ( key.length ) {
            qparam += "q=" + key
        }
        if ( cat_id != -1  ) {
            qparam += "&cat_id=" + cat_id
        }


        TurnOverlayOn();
        axios.get(`/dashboard/pos/search${qparam}`)
            .then(response => {
                setStocks(response.data.stocks);
                TurnOverlayOff();
            });
    }


    return (
        <>
            <div className="product-container" id="left">
                <div className="product-controls">
                    <div className="search-box">
                    <span className="search-icon">
                        <i className="uil uil-search-alt"></i>
                    </span>
                        <input onInput={search} type="text" ref={keyFilter} placeholder="Search Here" id="search-box-input" />
                        <span className="qr-icon">
                        <i className="mdi mdi-qrcode-scan"></i>
                    </span>
                    </div>
                    <div className="selectors">
                        <select onChange={() => { search() }} ref={catFilter} name="category" id="category" className="category">
                            <option value="-1">All Category</option>
                            {
                                categories.map((category, i)=>{
                                    return <option key={i} value={category.id}>{category.name}</option>
                                })
                            }
                        </select>
                    </div>
                </div>
                <div className="products-container">
                    {
                        stocks.map((stock, i) => {
                            return (
                                <div className="product" key={i}>
                                    <div className="product-image">
                                        <img src={'/category/' + stock.medicine.image } alt="Image" />
                                    </div>
                                    <div className="product-title">{ stock.medicine.name }</div>
                                    <div className="product-price">
                                        <span className="badge">
                                            MRP: { stock.medicine.price }
                                        </span>
                                    </div>
                                    <div className="product-expiry">
                                        <span className="badge">
                                            EXPIRY: { stock.expiry_date }
                                        </span>
                                    </div>
                                    <div className="product-category">
                                        <span className="badge">
                                            CATEGORY: { stock.medicine.category.name }
                                        </span>
                                    </div>
                                    <div className="product-category">
                                        <span className="badge">
                                            STOCKS: { stock.quantity }
                                        </span>
                                    </div>
                                    <div className="product-add-button">
                                        <button onClick={ () => addToCart(stock.medicine.id) }>Add</button>
                                    </div>
                                </div>
                            )
                        })
                    }
                </div>
            </div>
        </>
    )
}


export default Left;
