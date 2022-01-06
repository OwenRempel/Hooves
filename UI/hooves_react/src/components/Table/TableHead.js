function TableHead({ Head }) {
    if(localStorage.getItem('DisplayItems')){
        let DispItem = JSON.parse(localStorage.getItem('DisplayItems'));
        for(let key in Head){
            if(!DispItem[key]){
                delete(Head[key])
            }
        }
    }

    return (
        <thead>
            <tr>
                {
                Object.keys(Head).map((key, i) => (
                    <th key={i}>{Head[key]}</th>
                    
                ))
                }
            </tr>
        </thead>
    )
}

export default TableHead
