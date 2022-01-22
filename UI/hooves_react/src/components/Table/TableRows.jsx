import { Link } from "react-router-dom"

function TableRows({ Rows, UrlKey }) {
    let ID = ''
   
    Object.keys(Rows).map((key, i) => {
        if(key === "ID"){
            ID = Rows[key]
            delete Rows[key]
        }
     
       
        return(
            <></>
        )
    })
    return (
        <>
            <td>
                {
                    Object.keys(UrlKey).map((key, i) => (
                        <Link key={i} to={UrlKey[key].link+ID}>{UrlKey[key].title}</Link>
                    ))
                }
            </td>
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
