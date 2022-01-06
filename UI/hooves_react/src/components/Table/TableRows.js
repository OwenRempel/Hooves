function TableRows({ Rows }) {
    if(localStorage.getItem('DisplayItems')){
        let DispItem = JSON.parse(localStorage.getItem('DisplayItems'));
        for(let key in Rows){
            if(!DispItem[key]){
                delete(Rows[key])
            }
        }
    }
    return (
        <>
            {
                Object.keys(Rows).map((key, i) => (
                    <td key={i}>{Rows[key]}</td>
                ))
            }
        </>
    )
}

export default TableRows
