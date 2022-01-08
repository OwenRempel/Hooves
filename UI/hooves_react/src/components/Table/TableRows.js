import { Link } from "react-router-dom"

function TableRows({ Rows, UrlKey }) {
    let ID = ''
    Object.keys(Rows).map((key, i) => {
        if(key === "ID"){
           ID = UrlKey+Rows[key]
           delete Rows[key]
        }
        return(
            <div></div>
        )
    })
    return (
        <>
            <td><Link to={ID}>View</Link></td>
            {
                Object.keys(Rows).map((key, i) => {
                    return(
                        <td key={i}>{Rows[key]}</td>
                    )
                })
            }
        </>
    )
}

export default TableRows
