import { Link } from "react-router-dom"

function TableRows({ Rows, UrlKey }) {
    let ID = ''
    
    ID = Rows.ID
   
    return (
        <>
            <td>
                {
                    Object.keys(UrlKey).map((key, i) => (
                        <Link key={i} className={UrlKey[key].className ? UrlKey[key].className : 'linkClick'} to={UrlKey[key].link+ID}>{UrlKey[key].title}</Link>
                    ))
                }
            </td>
            {
                Object.keys(Rows).map((key, i) => {
                    if(key !== 'ID'){
                        return <td key={i}>{Rows[key]}</td>
                    }else{
                        return false
                    }
                })
            }
        </>
    )
}

export default TableRows
